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
 * Test SMTP account page.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

require_once('../../../config.php');
require_login();

$context = context_system::instance();
require_capability('local/smartsmtp:manageaccounts', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/smartsmtp/admin/test_account.php'));
$PAGE->set_title(get_string('test_connection', 'local_smartsmtp'));
$PAGE->set_heading(get_string('test_connection', 'local_smartsmtp'));
$PAGE->set_pagelayout('admin');

global $DB, $OUTPUT, $CFG;

$accountid = required_param('id', PARAM_INT);
$send       = optional_param('send', 0, PARAM_BOOL);
$toemail   = optional_param('to_email', '', PARAM_EMAIL);

$record  = $DB->get_record('smartsmtp_accounts', ['id' => $accountid], '*', MUST_EXIST);
$account = new \local_smartsmtp\smtp_account($record);

echo $OUTPUT->header();
echo $OUTPUT->heading(
    get_string('test_connection', 'local_smartsmtp') . ': ' .
    format_string($account->name),
    3
);

if ($send && $toemail && confirm_sesskey()) {
    $originalsmtp = [
        'smtphosts'      => $CFG->smtphosts ?? '',
        'smtpuser'       => $CFG->smtpuser ?? '',
        'smtppass'       => $CFG->smtppass ?? '',
        'smtpsecure'     => $CFG->smtpsecure ?? '',
        'noreplyaddress' => $CFG->noreplyaddress ?? '',
    ];

    $CFG->smtphosts  = $account->host . ':' . $account->port;
    $CFG->smtpuser   = $account->username;
    $CFG->smtppass   = $account->get_decrypted_password();
    $CFG->smtpsecure = $account->security;

    $noreplyemail = !empty($account->noreply_email)
        ? $account->noreply_email
        : $account->username;
    $CFG->noreplyaddress = $noreplyemail;

    $fromuser            = \core_user::get_noreply_user();
    $fromuser            = clone $fromuser;
    $fromuser->email     = $noreplyemail;
    $fromuser->maildisplay = 0;

    // Construir touser.
    $touser              = \core_user::get_noreply_user();
    $touser              = clone $touser;
    $touser->email       = $toemail;
    $touser->firstname   = 'Test';
    $touser->lastname    = 'User';
    $touser->mailformat  = 1;

    $subject = get_string('test_email_subject', 'local_smartsmtp');
    $body    = get_string('test_email_body', 'local_smartsmtp', $account->name);

    $result = email_to_user($touser, $fromuser, $subject, $body);

    $CFG->smtphosts      = $originalsmtp['smtphosts'];
    $CFG->smtpuser       = $originalsmtp['smtpuser'];
    $CFG->smtppass       = $originalsmtp['smtppass'];
    $CFG->smtpsecure     = $originalsmtp['smtpsecure'];
    $CFG->noreplyaddress = $originalsmtp['noreplyaddress'];

    \local_smartsmtp\smtp_logger::log(
        $account->id,
        $toemail,
        $subject,
        $result ? 'sent' : 'failed',
        $result ? null : 'Test de conexión manual'
    );

    if ($result) {
        echo $OUTPUT->notification(
            'Correo enviado correctamente a ' . $toemail . ' desde ' . $noreplyemail,
            'success'
        );
    } else {
        echo $OUTPUT->notification(
            'Error al enviar. Verifica la configuración del buzón.',
            'error'
        );
    }
}

echo html_writer::start_div('card mt-3');
echo html_writer::start_div('card-body');
echo html_writer::tag('h5', 'Configuración del buzón', ['class' => 'card-title']);
$table = new html_table();
$table->attributes['class'] = 'table table-sm';
$noreplydisplay = !empty($account->noreply_email) ? $account->noreply_email : $account->username . ' (username como fallback)';
$table->data = [
    ['Host', $account->host . ':' . $account->port],
    ['Seguridad', strtoupper($account->security ?: 'None')],
    ['Usuario SMTP', $account->username],
    ['From (noreply)', $noreplydisplay],
    ['Límite/día', $account->daily_limit == 0 ? 'Ilimitado' : $account->daily_limit],
    ['Enviados hoy', $account->get_daily_count()],
];
echo html_writer::table($table);
echo html_writer::end_div();
echo html_writer::end_div();

$testurl = new moodle_url('/local/smartsmtp/admin/test_account.php', [
    'id'      => $accountid,
    'send'    => 1,
    'sesskey' => sesskey(),
]);

echo html_writer::start_tag('form', ['method' => 'post', 'action' => $testurl->out(false), 'class' => 'mt-3']);
echo html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()]);
echo html_writer::start_div('card');
echo html_writer::start_div('card-body');
echo html_writer::tag('h5', 'Enviar correo de prueba', ['class' => 'card-title']);
echo html_writer::start_div('form-group');
echo html_writer::tag('label', 'Correo de destino', ['for' => 'to_email']);
echo html_writer::empty_tag('input', [
    'type' => 'email', 'name' => 'to_email', 'id' => 'to_email',
    'class' => 'form-control', 'placeholder' => 'tu@correo.com', 'required' => 'required',
]);
echo html_writer::end_div();
echo html_writer::tag('button', 'Enviar correo de prueba', ['type' => 'submit', 'class' => 'btn btn-primary mt-3']);
echo html_writer::end_div();
echo html_writer::end_div();
echo html_writer::end_tag('form');

echo html_writer::link(
    new moodle_url('/local/smartsmtp/admin/accounts.php'),
    '← Volver a cuentas',
    ['class' => 'btn btn-outline-secondary mt-3']
);

echo $OUTPUT->footer();
