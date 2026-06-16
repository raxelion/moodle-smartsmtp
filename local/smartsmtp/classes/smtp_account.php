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
 * smtp account class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace local_smartsmtp;

/**
 * SMTP account data object.
 */
class smtp_account {
        /**
         * @var int $id Account ID.
         */
    public int $id;
        /**
         * @var string $name Account display name.
         */
    public string $name;
        /**
         * @var string $host SMTP server hostname.
         */
    public string $host;
        /**
         * @var int $port SMTP port.
         */
    public int $port;
        /**
         * @var string $username SMTP authentication username.
         */
    public string $username;
        /**
         * @var string $password Encrypted SMTP password.
         */
    private string $password;
        /**
         * @var string $security Connection security (none/ssl/tls).
         */
    public string $security;
        /**
         * @var int $daily_limit Maximum emails per day (0 = unlimited).
         */
    public int $dailylimit;
        /**
         * @var bool $is_default Whether this is the default account.
         */
    public bool $isdefault;
        /**
         * @var bool $enabled Whether this account is active.
         */
    public bool $enabled;
        /**
         * @var int $timecreated Unix timestamp of creation.
         */
    public int $timecreated;
        /**
         * @var string $noreply_email Noreply email address.
         */
    public string $noreplyemail;
        /**
         * @var string $noreply_name Noreply display name.
         */
    public string $noreplyname;

        /**
         * Constructs an smtp_account from a database record.
         *
         * @param \stdClass $record Database record.
         */
    public function __construct(\stdClass $record) {
        $this->id            = (int)$record->id;
        $this->name          = $record->name;
        $this->host          = $record->host;
        $this->port          = (int)$record->port;
        $this->username      = $record->username;
        $this->password      = $record->password;
        $this->security      = $record->security;
        $this->dailylimit   = (int)$record->daily_limit;
        $this->isdefault    = (bool)$record->is_default;
        $this->enabled       = (bool)$record->enabled;
        $this->timecreated   = (int)($record->timecreated ?? 0);
        $this->noreplyemail = $record->noreply_email ?? '';
        $this->noreplyname  = $record->noreply_name ?? '';
    }

        /**
         * Returns the decrypted SMTP password.
         */
    public function get_decrypted_password(): string {
        return \core\encryption::decrypt($this->password);
    }

        /**
         * Encrypts a plain text password for storage.
         */
    public static function encrypt_password(string $plain): string {
        return \core\encryption::encrypt($plain);
    }

        /**
         * Returns the number of emails sent today for this account.
         */
    public function get_daily_count(): int {
        // Leer desde BD via smtp_logger para garantizar.
        // consistencia entre requests del cron.
        return smtp_logger::get_daily_count($this->id);
    }

        /**
         * Returns true if this account can still send emails today.
         */
    public function has_capacity(): bool {
        if ($this->dailylimit === 0) {
            return true;
        }
        return $this->get_daily_count() < $this->dailylimit;
    }

    /**
     * Aplica la config noreply de este buzón a Moodle ($CFG) y a la BD de config.
     *
     * Moodle usa $CFG->noreplyaddress para el campo "From" de correos del sistema.
     * Si el admin configura un noreply por buzón, lo tomamos como fuente de verdad
     * para esa cuenta. El hook after_config lo aplica al inicio de cada request.
     *
     * Si noreply_email está vacío, usa el username del buzón como fallback
     * (que es el correo SMTP autenticado — correcto para la mayoría de proveedores).
     */
    public static function apply_noreply_config(string $email, string $name): void {
        global $CFG;

        // IMPORTANTE: NO escribir en BD de Moodle (set_config).
        // Si escribimos noreplyaddress en BD, Moodle lo muestra en.
        // "Configuración de correo de salida" y pisa la config global.
        // cada vez que se guarda un buzón — lo que causa que todos los.
        // envíos usen el noreply del último buzón guardado, ignorando.
        // el buzón seleccionado por las reglas.
        //
        // Solo guardamos el noreply del buzón en nuestra propia config.
        // para que hook_callbacks lo aplique al $CFG en cada request.

        $effectiveemail = !empty($email) ? $email : '';
        $effectivename  = !empty($name) ? $name : '';

        // Guardar en config propia del plugin (no en config global de Moodle).
        set_config('default_noreply_email', $effectiveemail, 'local_smartsmtp');
        set_config('default_noreply_name', $effectivename, 'local_smartsmtp');
    }

    /**
     * Aplica noreply desde el buzón default al inicio del request (hook after_config).
     * Llamado por hook_callbacks::after_config() después de configurar el SMTP.
     */
    public function apply_own_noreply(): void {
        global $CFG;

        // Aplicar noreply de ESTE buzón solo al $CFG del request actual.
        // No escribir en BD — eso pisaría la config global de Moodle.
        $email = !empty($this->noreplyemail) ? $this->noreplyemail : $this->username;
        $name  = !empty($this->noreplyname)
                 ? $this->noreplyname
                 : get_config('local_smartsmtp', 'default_noreply_name');

        $CFG->noreplyaddress = $email;
        // NO tocar $CFG->smtpreplyaddress — ese es el Reply-To, diferente al From.
    }

        /**
         * Returns a stdClass record suitable for database insertion.
         */
    public function to_record(): \stdClass {
        return (object)[
            'id'            => $this->id,
            'name'          => $this->name,
            'host'          => $this->host,
            'port'          => $this->port,
            'username'      => $this->username,
            'password'      => $this->password,
            'security'      => $this->security,
            'daily_limit'   => $this->dailylimit,
            'is_default'    => (int)$this->isdefault,
            'enabled'       => (int)$this->enabled,
            'timecreated'   => $this->timecreated ?: time(),
            'noreply_email' => $this->noreplyemail,
            'noreply_name'  => $this->noreplyname,
        ];
    }
}
