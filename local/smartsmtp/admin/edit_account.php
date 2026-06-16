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
 * Edit SMTP account page.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

require_once('../../../config.php');
require_login();
global $CFG, $DB, $PAGE, $OUTPUT;

$context = context_system::instance();
require_capability('local/smartsmtp:manageaccounts', $context);

$id = optional_param('id', 0, PARAM_INT);

// Verificar si la edición está permitida en el plan actual.
$accountcount = $DB->count_records('smartsmtp_accounts');
if ($id && !\local_smartsmtp\license::can_edit_mailbox($accountcount)) {
    redirect(
        new moodle_url('/local/smartsmtp/admin/accounts.php'),
        get_string('edit_blocked_reduce_accounts', 'local_smartsmtp'),
        null,
        \core\output\notification::NOTIFY_ERROR
    );
}

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/smartsmtp/admin/edit_account.php', ['id' => $id]));
$PAGE->set_title(get_string($id ? 'edit_account' : 'add_account', 'local_smartsmtp'));
$PAGE->set_heading(get_string($id ? 'edit_account' : 'add_account', 'local_smartsmtp'));
$PAGE->set_pagelayout('admin');

$record = $id
    ? $DB->get_record('smartsmtp_accounts', ['id' => $id], '*', MUST_EXIST)
    : (object)[
        'id'            => 0,
        'port'          => 587,
        'security'      => 'tls',
        'daily_limit'   => 500,
        'enabled'       => 1,
        'is_default'    => 0,
        'noreply_email' => '',
        'noreply_name'  => '',
    ];

require_once($CFG->dirroot . '/local/smartsmtp/classes/forms/account_form.php');

$form = new \local_smartsmtp\forms\account_form(
    new moodle_url('/local/smartsmtp/admin/edit_account.php', ['id' => $id]),
    ['record' => $record]
);

if ($form->is_cancelled()) {
    redirect(new moodle_url('/local/smartsmtp/admin/accounts.php'));
} else if ($data = $form->get_data()) {
    if (!empty($data->password_new)) {
        $data->password = \local_smartsmtp\smtp_account::encrypt_password($data->password_new);
    } else {
        $data->password = $record->password ?? '';
    }
    unset($data->password_new);

    if (!empty($data->is_default)) {
        $DB->set_field('smartsmtp_accounts', 'is_default', 0);
    }

    // Verificar limite free al crear.
    if (!$id) {
        $count  = $DB->count_records('smartsmtp_accounts');
        if (!\local_smartsmtp\license::can_add_mailbox($count)) {
            redirect(
                new moodle_url('/local/smartsmtp/admin/accounts.php'),
                get_string('max_accounts_reached', 'local_smartsmtp'),
                null,
                \core\output\notification::NOTIFY_ERROR
            );
        }
    }

    if ($id) {
        $data->id = $id;
        $DB->update_record('smartsmtp_accounts', $data);
        $msg = get_string('account_updated', 'local_smartsmtp');
    } else {
        $data->timecreated = time();
        $DB->insert_record('smartsmtp_accounts', $data);
        $msg = get_string('account_created', 'local_smartsmtp');
    }

    // Si es default, aplicar noreply a config global de Moodle.
    if (!empty($data->is_default)) {
        \local_smartsmtp\smtp_account::apply_noreply_config(
            $data->noreply_email ?? '',
            $data->noreply_name ?? ''
        );
    }

    redirect(
        new moodle_url('/local/smartsmtp/admin/accounts.php'),
        $msg,
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string($id ? 'edit_account' : 'add_account', 'local_smartsmtp'), 3);
$form->display();
echo html_writer::link(
    new moodle_url('/local/smartsmtp/admin/accounts.php'),
    '← ' . get_string('manage_accounts', 'local_smartsmtp'),
    ['class' => 'btn btn-outline-secondary btn-sm mt-3']
);
echo $OUTPUT->footer();
