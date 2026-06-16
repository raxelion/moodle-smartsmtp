<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify.
// it under the terms of the GNU General Public License as published by.
// the Free Software Foundation, either version 3 of the License, or.
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,.
// but WITHOUT ANY WARRANTY; without even the implied warranty of.
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the.
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License.
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * SmartSMTP License — validación RSA asimétrica.
 *
 * ARQUITECTURA DE SEGURIDAD:
 *  - Tu servidor firma con clave PRIVADA RSA-2048 (nunca sale de tu servidor).
 *  - Este archivo embebe la clave PÚBLICA. Con ella se puede verificar,
 *    pero NUNCA forjar una licencia válida.
 *  - La validación es 100% local: no hace llamadas HTTP en cada request.
 *  - La caché incluye el siteidentifier de Moodle: copiar la caché a otro
 *    servidor no funciona porque el siteidentifier no coincidirá.
 *  - Caducidad de caché: 7 días. Pasados 7 días re-verifica la clave guardada.
 *  - Si la clave es inválida o caducó: degrada silenciosamente a free.
 *    NUNCA bloquea el envío de correo.
 *
 * FLUJO DE ACTIVACIÓN (admin del cliente):
 *  1. Compra en tu tienda → recibe una "license key" (string base64.base64).
 *  2. La pega en Administración → SmartSMTP → Configuración → Clave de licencia.
 *  3. Este archivo verifica la firma RSA localmente y activa las features.
 *
 * PARA PRODUCCIÓN:
 *  Reemplaza la constante PUBLIC_KEY_DEV por tu clave pública de producción.
 *  Genera tu propio par en tu servidor con:
 *    openssl genrsa -out prod_private.pem 2048
 *    openssl rsa -in prod_private.pem -pubout -out prod_public.pem
 *  Guarda prod_private.pem SOLO en tu servidor de licencias.
 *  Pon el contenido de prod_public.pem en PUBLIC_KEY_PROD abajo.
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 * @package local_smartsmtp
 */

namespace local_smartsmtp;

/**
 * License validation and feature gating for SmartSMTP Premium.
 */
class license {
    private /**
 * @var string RSA public key for license signature verification.
 */
    const PUBLIC_KEY_PROD =
        '-----BEGIN PUBLIC KEY-----' . "\n" .
        'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAnB+pD8A2WHja2E82nY2g' . "\n" .
        'k51RiXXart1c6qCrUlEQk4K/ZQX8WedeB0ZndJERdc911Y2thaAQHis4OY9CwAtC' . "\n" .
        'hEeIPFQMPz55tEUVNaghMI8vyNdupTGoyu6WnZal5hc3pVZXFpmfeKGXMADxzA2u' . "\n" .
        'nRm/WDImYUB72KQMpzG5e/iauYrSH9ZZ/WgKRw1rLeELbwiNG9jJ9PfEeuH5GxJx' . "\n" .
        'B25Xvx/cbUxb/DJ81xTqOncFIJG9BtR42Z5We5c3eWaSbjiaj4MYdL6vUZZ8Udvn' . "\n" .
        'jHZ6liXOfkSvy7Lx8Ny4V5WdAiIpiT3ttuactpNWX26HK4Fa3nEtPgegbRWQhXMe' . "\n" .
        '9QIDAQAB' . "\n" .
        '-----END PUBLIC KEY-----';

    private /**
 * @var int License validation cache duration in seconds.
 */
    const CACHE_TTL = 604800;

    /**
     * @var string Signed free plan payload — limits enforced by RSA signature.
     */
    private const FREE_LICENSE = 'eyJwbGFuIjoiZnJlZSIsIm1heF9tYWlsYm94ZXMiOjIsIm1heF9ydWxlcyI6MiwiZmVhdHVyZXMiOltdfQ==.ZAwXt59cQES4cnCgt9kw3wekjpMXSkz6rZLjFGGYTtV2haGcBeZq3HzycmgC68TGSU2iCrA4gQ1Li4SHlxySbEyXNzQRt5FJTZ+/vKPx3Ok8OUa9gQRT2h5RfwkMQAKtm/W+2G2H+QSCOttYfQ/2+PbQaQ/uIgEG7n00RIS8XujNYqoxLDvxs8cWz5+jaNV7tFHna2v0krv7IlEVhpgif9hAkbIaChHegE8hnsJjeh8EYe6DG+uYTx8N9SgLI1z5V7zMgeTyHGGWQXphxIyBQypDjIxakBt1Lz0sRfOb1HrMpLN3lPpYC0UnRBKSKDRybHjfZraVWVwl2PS8p2OVyg==';

    public /**
 * @var string Feature flag: unlimited SMTP accounts.
 */
    const FEATURE_UNLIMITED_MAILBOXES = 'unlimited_mailboxes';
    public /**
 * @var string Feature flag: unlimited routing rules.
 */
    const FEATURE_UNLIMITED_RULES     = 'unlimited_rules';
    public /**
 * @var string Feature flag: per-notification-name routing.
 */
    const FEATURE_NAME_GRANULARITY    = 'name_granularity';
    public /**
 * @var string Feature flag: round-robin load balancing.
 */
    const FEATURE_ROUND_ROBIN         = 'roundrobin';

    public /**
 * @var int Maximum SMTP accounts in the free plan (informational only).
 */
    const FREE_MAX_MAILBOXES = 2;
    public /**
 * @var int Maximum routing rules in the free plan (informational only).
 */
    const FREE_MAX_RULES     = 2;

        /**
         * Returns true if the site has a valid premium license.
         */
    public static function is_premium(): bool {
        return self::has_feature(self::FEATURE_UNLIMITED_MAILBOXES);
    }

        /**
         * Returns true if the given feature is available.
         */
    public static function has_feature(string $feature): bool {
        $data = self::get_validated_payload();
        if ($data === null) {
            return false;
        }
        return in_array($feature, $data['features'] ?? [], true);
    }

        /**
         * Returns the account and rule limits for the current plan.
         */
    public static function get_limits(): array {
        $data = self::get_validated_payload();

        if ($data !== null) {
            return [
                'max_mailboxes'    => isset($data['max_mailboxes'])
                    ? (int)$data['max_mailboxes']
                    : PHP_INT_MAX,
                'max_rules'        => isset($data['max_rules'])
                    ? (int)$data['max_rules']
                    : PHP_INT_MAX,
                'roundrobin'       => self::has_feature(self::FEATURE_ROUND_ROBIN),
                'name_granularity' => self::has_feature(self::FEATURE_NAME_GRANULARITY),
            ];
        }

        return [
            'max_mailboxes'    => self::FREE_MAX_MAILBOXES,
            'max_rules'        => self::FREE_MAX_RULES,
            'roundrobin'       => false,
            'name_granularity' => false,
        ];
    }

    /**
     * Returns true if a new mailbox can be added given the current count.
     */
    public static function can_add_mailbox(int $current): bool {
        $limits = self::get_limits();
        if ($limits['max_mailboxes'] === PHP_INT_MAX) {
            return true;
        }
        return $current < $limits['max_mailboxes'];
    }

    /**
     * Returns true if a new routing rule can be added given the current count.
     */
    public static function can_add_rule(int $current): bool {
        $limits = self::get_limits();
        if ($limits['max_rules'] === PHP_INT_MAX) {
            return true;
        }
        return $current < $limits['max_rules'];
    }

    /**
     * Returns the number of days until the premium license expires, or null if not premium.
     */
    public static function days_until_expiry(): ?int {
        $key = get_config('local_smartsmtp', 'license_key');
        if (empty(trim($key))) {
            return null;
        }
        $data = self::verify_license_key(trim($key));
        if ($data === null || empty($data['expires'])) {
            return null;
        }
        $ts = strtotime($data['expires']);
        if ($ts === false) {
            return null;
        }
        $days = (int)ceil(($ts - time()) / 86400);
        return $days;
    }

    /**
     * Returns true if premium license is expiring within the grace period (30 days).
     */
    public static function is_expiring_soon(): bool {
        $days = self::days_until_expiry();
        if ($days === null) {
            return false;
        }
        return $days >= 0 && $days <= 30;
    }

    /**
     * Returns true if a premium license key exists but has expired.
     */
    public static function is_expired_premium(): bool {
        $days = self::days_until_expiry();
        if ($days === null) {
            return false;
        }
        return $days < 0;
    }

    /**
     * Returns true if editing mailboxes is allowed given current count.
     * Blocked when premium expired and count exceeds free limit.
     */
    public static function can_edit_mailbox(int $current): bool {
        if (self::is_premium()) {
            return true;
        }
        if (self::is_expiring_soon()) {
            return true;
        }
        return $current <= self::FREE_MAX_MAILBOXES;
    }

        /**
         * Returns the full license status array.
         */
    public static function get_status(): array {
        $key = get_config('local_smartsmtp', 'license_key');

        if (empty($key)) {
            return [
                'status'   => 'free',
                'plan'     => 'free',
                'domain'   => '',
                'expires'  => '',
                'features' => [],
                'limits'   => self::get_limits(),
            ];
        }

        $data = self::get_validated_payload();

        if ($data === null) {
            return [
                'status'   => 'invalid',
                'plan'     => 'free',
                'domain'   => '',
                'expires'  => '',
                'features' => [],
            ];
        }

        return [
            'status'   => 'active',
            'plan'     => 'premium',
            'domain'   => $data['domain'] ?? '',
            'expires'  => $data['expires'] ?? '',
            'features' => $data['features'] ?? [],
        ];
    }

        /**
         * Clears the cached license validation result.
         */
    public static function invalidate_cache(): void {
        $cache = \cache::make('local_smartsmtp', 'license');
        $cache->delete(self::cache_key());
    }

        /**
         * Returns the validated license payload or null if invalid.
         */
    private static function get_validated_payload(): ?array {
        $cached = self::get_cache();
        if ($cached !== null) {
            return $cached;
        }

        $key = get_config('local_smartsmtp', 'license_key');

        if (empty(trim($key))) {
            return self::get_free_payload();
        }

        $data = self::verify_license_key(trim($key));
        if ($data === null) {
            return self::get_free_payload();
        }

        if (!self::domain_matches($data['domain'] ?? '')) {
            debugging('SmartSMTP: licencia rechazada — dominio no coincide.', DEBUG_DEVELOPER);
            return self::get_free_payload();
        }

        if (!self::is_not_expired($data['expires'] ?? '')) {
            debugging('SmartSMTP: licencia rechazada — expirada.', DEBUG_DEVELOPER);
            return self::get_free_payload();
        }

        self::set_cache($data);

        return $data;
    }

        /**
         * Returns the embedded free plan payload verified by RSA signature.
         */
    private static function get_free_payload(): ?array {
        $data = self::verify_license_key(self::FREE_LICENSE);
        if (!is_array($data)) {
            return null;
        }
        return $data;
    }

        /**
         * Verifies a license key signature using RSA.
         */
    private static function verify_license_key(string $licensekey): ?array {
        $parts = explode('.', $licensekey, 2);
        if (count($parts) !== 2) {
            return null;
        }

        [$b64payload, $b64signature] = $parts;

        $payloadjson = base64_decode($b64payload, true);
        $signature    = base64_decode($b64signature, true);

        if ($payloadjson === false || $signature === false) {
            return null;
        }

        $publickeypem = self::get_active_public_key();

        $pubkey = openssl_pkey_get_public($publickeypem);
        if ($pubkey === false) {
            debugging('SmartSMTP: clave pública inválida en el código.', DEBUG_DEVELOPER);
            return null;
        }

        $result = openssl_verify($payloadjson, $signature, $pubkey, OPENSSL_ALGO_SHA256);

        if ($result !== 1) {
            return null;
        }

        $data = json_decode($payloadjson, true);
        if (!is_array($data)) {
            return null;
        }

        return $data;
    }

        /**
         * Returns the active RSA public key.
         */
    private static function get_active_public_key(): string {
        return self::PUBLIC_KEY_PROD;
    }

        /**
         * Returns true if the licensed domain matches the current host.
         */
    private static function domain_matches(string $licenseddomain): bool {
        global $CFG;

        if (empty($licenseddomain)) {
            return false;
        }

        $ourhost = strtolower(parse_url($CFG->wwwroot, PHP_URL_HOST) ?? '');

        if (empty($ourhost)) {
            return false;
        }

        $licenseddomain = strtolower(trim($licenseddomain));

        if ($ourhost === $licenseddomain) {
            return true;
        }

        if (str_starts_with($licenseddomain, '*.')) {
            $base = substr($licenseddomain, 2);
            if (str_ends_with($ourhost, '.' . $base) || $ourhost === $base) {
                return true;
            }
        }

        return false;
    }

        /**
         * Returns true if the license has not expired.
         */
    private static function is_not_expired(string $expiresdate): bool {
        if (empty($expiresdate)) {
            return false;
        }

        $ts = strtotime($expiresdate);
        if ($ts === false) {
            return false;
        }

        return $ts >= mktime(0, 0, 0, (int)date('m'), (int)date('d'), (int)date('Y'));
    }

        /**
         * Returns the cache key for license data.
         */
    private static function cache_key(): string {
        return 'validated_' . md5(self::get_site_identifier());
    }

        /**
         * Returns cached license data or null if not cached.
         */
    private static function get_cache(): ?array {
        try {
            $cache  = \cache::make('local_smartsmtp', 'license');
            $cached = $cache->get(self::cache_key());

            if ($cached === false || !is_array($cached)) {
                return null;
            }

            $cachedat = $cached['_cached_at'] ?? 0;
            if ((time() - $cachedat) > self::CACHE_TTL) {
                $cache->delete(self::cache_key());
                return null;
            }

            unset($cached['_cached_at'], $cached['_site_id']);
            return $cached;
        } catch (\Throwable $e) {
            return null;
        }
    }

        /**
         * Stores license data in the plugin config cache.
         */
    private static function set_cache(array $data): void {
        try {
            $cache = \cache::make('local_smartsmtp', 'license');

            $tostore = $data;
            $tostore['_cached_at'] = time();
            $tostore['_site_id']   = self::get_site_identifier();

            $cache->set(self::cache_key(), $tostore);
        } catch (\Throwable $e) {
            // Non-fatal: if cache write fails, license is re-validated on next request.
            debugging('SmartSMTP license cache write failed: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }

        /**
         * Returns a unique identifier for this Moodle site.
         */
    private static function get_site_identifier(): string {
        return get_config('core', 'siteidentifier') ?? 'unknown';
    }
}