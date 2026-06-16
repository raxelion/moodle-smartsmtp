<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * hook callbacks class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp;

/**
 * Hook callback handlers for local_smartsmtp.
 */
class hook_callbacks {
        /**
         * Applies SmartSMTP configuration after Moodle config is loaded.
         */
    public static function after_config(\core\hook\after_config $hook): void {
        global $CFG, $DB;

        if (empty($DB) || !$DB->get_manager()->table_exists('smartsmtp_accounts')) {
            return;
        }

        try {
            $default = $DB->get_record_select(
                'smartsmtp_accounts',
                'is_default = 1 AND enabled = 1',
                [],
                '*',
                IGNORE_MULTIPLE
            );

            if (!$default) {
                $default = $DB->get_record_select(
                    'smartsmtp_accounts',
                    'enabled = 1',
                    [],
                    '*',
                    IGNORE_MULTIPLE
                );
            }

            if ($default) {
                $account = new smtp_account($default);
                $CFG->smtphosts  = $account->host . ':' . $account->port;
                $CFG->smtpuser   = $account->username;
                $CFG->smtppass   = $account->get_decrypted_password();
                $CFG->smtpsecure = $account->security;
                $CFG->smartsmtp_current_account = $account->id;
                $account->apply_own_noreply();

                register_shutdown_function(
                    ['\local_smartsmtp\smtp_logger', 'flush_pending']
                );
            }
        } catch (\Throwable $e) {
            debugging('SmartSMTP hook error: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }
}
