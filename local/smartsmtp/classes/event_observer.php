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
 * event observer class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp;

/**
 * Moodle event observers for local_smartsmtp.
 */
class event_observer {
        /**
         * Handles email_failed events.
         */
    public static function email_failed(\core\event\email_failed $event): void {
        global $CFG, $DB;

        if (empty($CFG->smartsmtp_current_account) || empty($DB)) {
            return;
        }

        if (!$DB->get_manager()->table_exists('smartsmtp_logs')) {
            return;
        }

        try {
            $data  = $event->get_data();
            $other = $data['other'] ?? [];

            $recipient = '';
            if (!empty($data['relateduserid'])) {
                $user = $DB->get_record(
                    'user',
                    ['id' => $data['relateduserid']],
                    'email',
                    IGNORE_MISSING
                );
                $recipient = $user->email ?? '';
            }

            smtp_logger::log(
                (int)$CFG->smartsmtp_current_account,
                $recipient,
                $other['subject'] ?? '',
                'failed',
                $other['errorinfo'] ?? 'Unknown error'
            );
        } catch (\Throwable $e) {
            debugging('SmartSMTP observer error: ' . $e->getMessage(), DEBUG_DEVELOPER);
        }
    }

        /**
         * Handles cron_executed events.
         */
    public static function on_cron_executed(\core\event\cron_executed $event): void {
    }

        /**
         * Handles user_updated events.
         */
    public static function user_updated(\core\event\user_updated $event): void {
    }

        /**
         * Processes user_updated event data.
         */
    public static function on_user_updated(\core\event\user_updated $event): void {
        self::user_updated($event);
    }
}
