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
 * SmartSMTP email send logger
 *
 * @package    local_smartsmtp
 * @copyright  2024 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace local_smartsmtp;

/**
 * SMTP send log manager.
 */
class smtp_logger {
        /**
         * Logs an email send attempt directly to the database.
         */
    public static function log($accountid, $recipient, $subject, $status, $error = null) {
        global $DB;

        $DB->insert_record('smartsmtp_logs', (object)[
            'account_id' => $accountid,
            'recipient'  => $recipient,
            'subject'    => $subject,
            'status'     => $status,
            'error_msg'  => $error,
            'timesent'   => time(),
        ]);

        if ($status === 'sent') {
            self::increment_daily_counter($accountid);
        }
    }

    /**
     * Incrementa el contador diario en BD para garantizar persistencia
     * entre requests del cron. La caché no persiste entre subprocesos
     * en algunos entornos (Windows/Laragon, PHP-FPM con opcache).
     */
    private static function increment_daily_counter(int $accountid): void {
        global $DB;

        $today = date('Ymd');
        $existing = $DB->get_record('smartsmtp_daily_counts', [
            'account_id' => $accountid,
            'day'        => $today,
        ]);

        if ($existing) {
            $DB->set_field(
                'smartsmtp_daily_counts',
                'count',
                $existing->count + 1,
                ['id' => $existing->id]
            );
        } else {
            $DB->insert_record('smartsmtp_daily_counts', (object)[
                'account_id' => $accountid,
                'day'        => $today,
                'count'      => 1,
            ]);
        }

        // Actualizar también la caché para lecturas rápidas en el mismo request.
        $cache = \cache::make('local_smartsmtp', 'daily_counts');
        $key   = "account_{$accountid}_{$today}";
        $cache->set($key, ($existing->count ?? 0) + 1);
    }

    /**
     * Obtiene el contador diario desde BD (fuente de verdad).
     * Siempre lee desde BD para garantizar consistencia entre
     * procesos del cron que corren en paralelo.
     */
    public static function get_daily_count(int $accountid): int {
        global $DB;

        $today = date('Ymd');

        $record = $DB->get_record('smartsmtp_daily_counts', [
            'account_id' => $accountid,
            'day'        => $today,
        ]);

        return $record ? (int)$record->count : 0;
    }

        /**
         * Flushes queued log entries to the database.
         * Kept for backwards compatibility — queue() now writes directly.
         */
    public static function flush_pending(): void {
        // No-op: queue() now writes directly to the database.
    }

        /**
         * Queues a log entry — writes directly to the database.
         */
    public static function queue(
        int $accountid,
        string $recipient,
        string $subject,
        string $status,
        ?string $error = null
    ): void {
        self::log($accountid, $recipient, $subject, $status, $error);
    }
}
