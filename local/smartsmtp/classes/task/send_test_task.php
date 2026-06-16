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
 * send test task class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp\task;

/**
 * Scheduled task: send a test email via a specific SMTP account.
 */
class send_test_task extends \core\task\adhoc_task {
        /**
         * Returns the task display name.
         */
    public function get_name(): string {
        return get_string('task_send_test', 'local_smartsmtp');
    }

        /**
         * Executes the task.
         */
    public function execute(): void {
        $data       = $this->get_custom_data();
        $accountid = $data->account_id;
        $toemail   = $data->to_email;

        global $DB, $CFG;

        $record = $DB->get_record(
            'smartsmtp_accounts',
            ['id' => $accountid],
            '*',
            MUST_EXIST
        );

        $account = new \local_smartsmtp\smtp_account($record);

        $CFG->smtphosts  = $account->host . ':' . $account->port;
        $CFG->smtpuser   = $account->username;
        $CFG->smtppass   = $account->get_decrypted_password();
        $CFG->smtpsecure = $account->security;

        $touser            = \core_user::get_noreply_user();
        $touser->email     = $toemail;
        $touser->firstname = 'Test';
        $touser->lastname  = 'User';

        $subject = get_string('test_email_subject', 'local_smartsmtp');
        $body    = get_string('test_email_body', 'local_smartsmtp', $account->name);

        $result = email_to_user($touser, \core_user::get_noreply_user(), $subject, $body);

        $cache = \cache::make('local_smartsmtp', 'test_results');
        $cache->set('result_' . $accountid, [
            'success'   => $result,
            'timestamp' => time(),
            'to'        => $toemail,
        ]);

        \local_smartsmtp\smtp_logger::log(
            $accountid,
            $toemail,
            $subject,
            $result ? 'sent' : 'failed',
            $result ? null : 'Test de conexión fallido'
        );
    }
}
