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
 * Accounts management page.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


require_once('../../../config.php');
require_login();

global $CFG, $DB, $OUTPUT, $PAGE;

$context = context_system::instance();
require_capability('local/smartsmtp:manageaccounts', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/smartsmtp/admin/accounts.php'));
$PAGE->set_title(get_string('manage_accounts', 'local_smartsmtp'));
$PAGE->set_heading(get_string('manage_accounts', 'local_smartsmtp'));
$PAGE->set_pagelayout('admin');

$action     = optional_param('action', '', PARAM_ALPHA);
$accountid = optional_param('id', 0, PARAM_INT);

if ($action && $accountid && confirm_sesskey()) {
    switch ($action) {
        case 'delete':
            $DB->delete_records('smartsmtp_accounts', ['id' => $accountid]);
            $DB->delete_records('smartsmtp_rules', ['account_id' => $accountid]);
            redirect(
                $PAGE->url,
                get_string('account_deleted', 'local_smartsmtp'),
                null,
                \core\output\notification::NOTIFY_SUCCESS
            );
            break;
        case 'enable':
            $DB->set_field('smartsmtp_accounts', 'enabled', 1, ['id' => $accountid]);
            redirect(
                $PAGE->url,
                get_string('account_updated', 'local_smartsmtp'),
                null,
                \core\output\notification::NOTIFY_SUCCESS
            );
            break;
        case 'disable':
            $DB->set_field('smartsmtp_accounts', 'enabled', 0, ['id' => $accountid]);
            redirect(
                $PAGE->url,
                get_string('account_updated', 'local_smartsmtp'),
                null,
                \core\output\notification::NOTIFY_SUCCESS
            );
            break;
        case 'setdefault':
            $DB->set_field('smartsmtp_accounts', 'is_default', 0);
            $DB->set_field('smartsmtp_accounts', 'is_default', 1, ['id' => $accountid]);
            redirect(
                $PAGE->url,
                get_string('account_updated', 'local_smartsmtp'),
                null,
                \core\output\notification::NOTIFY_SUCCESS
            );
            break;
    }
}

$accounts = $DB->get_records('smartsmtp_accounts', null, 'is_default DESC, name ASC');

$cache = cache::make('local_smartsmtp', 'daily_counts');
foreach ($accounts as $account) {
    $key = 'account_' . $account->id . '_' . date('Ymd');
    $account->daily_count = (int)($cache->get($key) ?: 0);
}

$limits          = \local_smartsmtp\license::get_limits();
$accountscount  = count($accounts);
$ispremium      = \local_smartsmtp\license::is_premium();
$expiringsoon   = \local_smartsmtp\license::is_expiring_soon();
$expiredpremium = \local_smartsmtp\license::is_expired_premium();
$canadd         = \local_smartsmtp\license::can_add_mailbox($accountscount);
$canedit        = \local_smartsmtp\license::can_edit_mailbox($accountscount);

$templatedata = [
    'accounts'    => array_values(array_map(function ($a) {
        return [
            'id'           => $a->id,
            'name'         => format_string($a->name),
            'host'         => $a->host,
            'port'         => $a->port,
            'username'     => $a->username,
            'security'     => strtoupper($a->security ?: 'None'),
            'daily_count'  => $a->daily_count,
            'daily_limit'  => $a->daily_limit == 0 ? '∞' : $a->daily_limit,
            'is_default'   => (bool)$a->is_default,
            'enabled'      => (bool)$a->enabled,
            'edit_url'     => (new moodle_url(
                '/local/smartsmtp/admin/edit_account.php',
                ['id' => $a->id]
            ))->out(false),
            'delete_url'   => (new moodle_url(
                '/local/smartsmtp/admin/accounts.php',
                ['action' => 'delete', 'id' => $a->id,
                'sesskey' => sesskey()]
            ))->out(false),
            'toggle_url'   => (new moodle_url(
                '/local/smartsmtp/admin/accounts.php',
                ['action' => $a->enabled ? 'disable' : 'enable',
                'id' => $a->id,
                'sesskey' => sesskey()]
            ))->out(false),
            'toggle_label' => $a->enabled
                ? get_string('disabled', 'local_smartsmtp')
                : get_string('enabled', 'local_smartsmtp'),
            'default_url'  => (new moodle_url(
                '/local/smartsmtp/admin/accounts.php',
                ['action' => 'setdefault', 'id' => $a->id,
                'sesskey' => sesskey()]
            ))->out(false),
            'test_url'     => (new moodle_url(
                '/local/smartsmtp/admin/test_account.php',
                ['id' => $a->id]
            ))->out(false),
        ];
    }, $accounts)),
    'add_url'     => (new moodle_url('/local/smartsmtp/admin/edit_account.php'))->out(false),
    'has_accounts' => $accountscount > 0,
    'can_add'     => $canadd,
    'can_edit'    => $canedit,
];

echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_smartsmtp/accounts_list', $templatedata);

// Aviso período de gracia — licencia vencida con buzones excedentes.
if ($expiredpremium && $accountscount > \local_smartsmtp\license::FREE_MAX_MAILBOXES) {
    $licenseurl = new moodle_url('/local/smartsmtp/admin/license.php');
    echo html_writer::start_div('alert alert-danger mt-3');
    echo html_writer::tag('h5', '⚠ ' . get_string('license_expired_title', 'local_smartsmtp'));
    echo html_writer::tag(
        'p',
        get_string('license_expired_accounts_desc', 'local_smartsmtp',
            (object)['count' => $accountscount, 'max' => \local_smartsmtp\license::FREE_MAX_MAILBOXES])
    );
    echo html_writer::link(
        $licenseurl->out(false),
        get_string('license_renew', 'local_smartsmtp') . ' →',
        ['class' => 'btn btn-danger btn-sm mr-2']
    );
    echo html_writer::end_div();
}

// Aviso licencia por vencer — período de gracia activo.
if ($expiringsoon) {
    $days = \local_smartsmtp\license::days_until_expiry();
    $licenseurl = new moodle_url('/local/smartsmtp/admin/license.php');
    echo html_writer::start_div('alert alert-warning mt-3');
    echo html_writer::tag('h5', '⏳ ' . get_string('license_expiring_title', 'local_smartsmtp'));
    echo html_writer::tag(
        'p',
        get_string('license_expiring_desc', 'local_smartsmtp', (object)['days' => $days])
    );
    echo html_writer::link(
        $licenseurl->out(false),
        get_string('license_renew', 'local_smartsmtp') . ' →',
        ['class' => 'btn btn-warning btn-sm']
    );
    echo html_writer::end_div();
}

if (!$ispremium) {
    $licenseurl = new moodle_url('/local/smartsmtp/admin/license.php');
    echo html_writer::start_div('alert alert-info mt-3');
    echo html_writer::tag('h5', 'SmartSMTP Premium');
    echo html_writer::tag(
        'p',
        get_string(
            'free_banner_desc',
            'local_smartsmtp',
            (object)['current' => $accountscount,
            'max'     => \local_smartsmtp\license::get_limits()['max_mailboxes']]
        )
    );
    echo html_writer::link(
        $licenseurl->out(false),
        get_string('upgrade_to_premium', 'local_smartsmtp') . ' →',
        ['class' => 'btn btn-primary btn-sm']
    );
    echo html_writer::end_div();
}

echo html_writer::div(
    html_writer::tag('span', '📖 ') .
    html_writer::link(
        get_string('docs_url', 'local_smartsmtp'),
        get_string('docs_link', 'local_smartsmtp'),
        ['target' => '_blank', 'rel' => 'noopener', 'class' => 'text-muted small']
    ),
    'text-right mt-2'
);
echo $OUTPUT->footer();