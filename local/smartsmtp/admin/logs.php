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
 * Email logs page.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_login();
require_capability('local/smartsmtp:viewlogs', context_system::instance());

global $CFG, $DB, $OUTPUT, $PAGE;

$accountid = optional_param('account_id', 0, PARAM_INT);
$status     = optional_param('status', '', PARAM_ALPHA);
$page       = optional_param('page', 0, PARAM_INT);
$perpage    = 50;

$PAGE->set_url(new moodle_url('/local/smartsmtp/admin/logs.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('email_logs', 'local_smartsmtp'));
$PAGE->set_heading(get_string('email_logs', 'local_smartsmtp'));
$PAGE->set_pagelayout('admin');

$where  = '1=1';
$params = [];

if ($accountid) {
    $where   .= ' AND l.account_id = :account_id';
    $params['account_id'] = $accountid;
}
if ($status) {
    $where   .= ' AND l.status = :status';
    $params['status'] = $status;
}

$total = $DB->count_records_sql(
    "SELECT COUNT(*) FROM {smartsmtp_logs} l WHERE $where",
    $params
);

$logs = $DB->get_records_sql("
    SELECT l.*, a.name as account_name
    FROM {smartsmtp_logs} l
    LEFT JOIN {smartsmtp_accounts} a ON a.id = l.account_id
    WHERE $where
    ORDER BY l.timesent DESC
", $params, $page * $perpage, $perpage);

echo $OUTPUT->header();

$accounts = $DB->get_records_menu('smartsmtp_accounts', null, 'name', 'id, name');
echo $OUTPUT->render_from_template('local_smartsmtp/log_filters', [
    'accounts'   => array_map(
        fn($id, $name) =>
        ['id' => $id, 'name' => $name, 'selected' => $id == $accountid],
        array_keys($accounts),
        $accounts
    ),
    'statuses'   => [
        ['value' => 'sent', 'label' => 'Enviado', 'selected' => $status === 'sent'],
        ['value' => 'failed', 'label' => 'Fallido', 'selected' => $status === 'failed'],
        ['value' => 'fallback', 'label' => 'Fallback', 'selected' => $status === 'fallback'],
    ],
]);

$table = new \flexible_table('smartsmtp-logs');
$table->define_columns(['timesent', 'account_name', 'recipient', 'subject', 'status', 'error_msg']);
$table->define_headers([
    get_string('date'),
    get_string('account', 'local_smartsmtp'),
    get_string('recipient', 'local_smartsmtp'),
    get_string('subject', 'local_smartsmtp'),
    get_string('status', 'local_smartsmtp'),
    get_string('error', 'local_smartsmtp'),
]);
$table->define_baseurl($PAGE->url);
$table->setup();

foreach ($logs as $log) {
    $statusbadge = \html_writer::span(
        get_string('status_' . $log->status, 'local_smartsmtp'),
        'badge badge-' . ($log->status === 'sent' ? 'success' : 'danger')
    );
    $table->add_data([
        userdate($log->timesent, get_string('strftimedatetimeshort', 'langconfig')),
        format_string($log->account_name),
        format_string($log->recipient),
        format_string($log->subject),
        $statusbadge,
        $log->error_msg ?? '—',
    ]);
}
$table->finish_output();

echo $OUTPUT->paging_bar($total, $page, $perpage, $PAGE->url);
echo $OUTPUT->footer();
