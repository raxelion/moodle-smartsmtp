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
 * License management page.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_login();

$context = context_system::instance();
require_capability('local/smartsmtp:manageaccounts', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/smartsmtp/admin/license.php'));
$PAGE->set_title(get_string('license_management', 'local_smartsmtp'));
$PAGE->set_heading(get_string('license_management', 'local_smartsmtp'));
$PAGE->set_pagelayout('admin');

global $DB, $OUTPUT;

$action = optional_param('action', '', PARAM_ALPHA);

if ($action && confirm_sesskey()) {
    if ($action === 'save') {
        $newkey = optional_param('license_key', '', PARAM_TEXT);
        $newkey = trim($newkey);
        set_config('license_key', $newkey, 'local_smartsmtp');
        \local_smartsmtp\license::invalidate_cache();
        if ($newkey === '') {
            redirect($PAGE->url, get_string('license_cleared', 'local_smartsmtp'),
                null, \core\output\notification::NOTIFY_SUCCESS);
        }
        $status = \local_smartsmtp\license::get_status();
        if ($status['status'] === 'active') {
            redirect($PAGE->url, get_string('license_activated', 'local_smartsmtp'),
                null, \core\output\notification::NOTIFY_SUCCESS);
        } else {
            redirect($PAGE->url, get_string('license_invalid_key', 'local_smartsmtp'),
                null, \core\output\notification::NOTIFY_ERROR);
        }
    }
    if ($action === 'clear') {
        set_config('license_key', '', 'local_smartsmtp');
        \local_smartsmtp\license::invalidate_cache();
        redirect($PAGE->url, get_string('license_cleared', 'local_smartsmtp'),
            null, \core\output\notification::NOTIFY_SUCCESS);
    }
}

$status         = \local_smartsmtp\license::get_status();
$currentkey     = get_config('local_smartsmtp', 'license_key') ?? '';
$ispremium      = $status['status'] === 'active';
$expiringsoon   = \local_smartsmtp\license::is_expiring_soon();
$expiredpremium = \local_smartsmtp\license::is_expired_premium();
$daysleft       = \local_smartsmtp\license::days_until_expiry();

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('license_management', 'local_smartsmtp'), 2);

// Aviso licencia por vencer.
if ($expiringsoon && $daysleft !== null) {
    echo html_writer::start_div('alert alert-warning');
    echo html_writer::tag('strong', '⏳ ' . get_string('license_expiring_title', 'local_smartsmtp'));
    echo ' ';
    echo get_string('license_expiring_desc', 'local_smartsmtp', (object)['days' => $daysleft]);
    echo html_writer::end_div();
}

// Aviso licencia vencida.
if ($expiredpremium) {
    $accountcount = $DB->count_records('smartsmtp_accounts');
    echo html_writer::start_div('alert alert-danger');
    echo html_writer::tag('strong', '⚠ ' . get_string('license_expired_title', 'local_smartsmtp'));
    echo ' ';
    if ($accountcount > \local_smartsmtp\license::FREE_MAX_MAILBOXES) {
        echo get_string('license_expired_accounts_desc', 'local_smartsmtp',
            (object)['count' => $accountcount, 'max' => \local_smartsmtp\license::FREE_MAX_MAILBOXES]);
    } else {
        echo get_string('license_expired_desc', 'local_smartsmtp');
    }
    echo html_writer::end_div();
}

$statusconfigs = [
    'active'  => ['class' => 'success', 'icon' => '✓', 'label' => get_string('license_status_active', 'local_smartsmtp')],
    'invalid' => ['class' => 'danger',  'icon' => '✗', 'label' => get_string('license_status_invalid', 'local_smartsmtp')],
    'free'    => ['class' => 'secondary','icon' => '—', 'label' => get_string('license_status_free', 'local_smartsmtp')],
    'no_key'  => ['class' => 'secondary','icon' => '—', 'label' => get_string('license_status_free', 'local_smartsmtp')],
];
$sc = $statusconfigs[$status['status']] ?? $statusconfigs['no_key'];

echo html_writer::start_div('card mb-4');
echo html_writer::start_div('card-body');
echo html_writer::start_div('d-flex align-items-center mb-3');
echo html_writer::tag('span', $sc['icon'] . ' ' . $sc['label'],
    ['class' => 'badge badge-' . $sc['class'] . ' px-3 py-2 mr-3', 'style' => 'font-size:1rem']);

if ($ispremium) {
    echo html_writer::start_div('');
    echo html_writer::tag('div',
        get_string('license_domain', 'local_smartsmtp') . ': ' .
        html_writer::tag('code', htmlspecialchars($status['domain'])),
        ['class' => 'small text-muted']);
    echo html_writer::tag('div',
        get_string('license_expires', 'local_smartsmtp') . ': ' .
        html_writer::tag('strong', htmlspecialchars($status['expires'])),
        ['class' => 'small text-muted']);
    if ($expiringsoon && $daysleft !== null) {
        echo html_writer::tag('div',
            html_writer::tag('span', '⏳ ' .
                get_string('license_days_left', 'local_smartsmtp', $daysleft),
                ['class' => 'badge badge-warning']),
            ['class' => 'mt-1']);
    }
    echo html_writer::end_div();
}
echo html_writer::end_div();

echo html_writer::tag('h6', get_string('license_features', 'local_smartsmtp'), ['class' => 'mt-3 mb-2']);

$allfeatures = [
    \local_smartsmtp\license::FEATURE_UNLIMITED_MAILBOXES => get_string('feature_unlimited_mailboxes', 'local_smartsmtp'),
    \local_smartsmtp\license::FEATURE_UNLIMITED_RULES     => get_string('feature_unlimited_rules', 'local_smartsmtp'),
    \local_smartsmtp\license::FEATURE_NAME_GRANULARITY    => get_string('feature_name_granularity', 'local_smartsmtp'),
    \local_smartsmtp\license::FEATURE_ROUND_ROBIN         => get_string('feature_roundrobin', 'local_smartsmtp'),
];

echo html_writer::start_tag('ul', ['class' => 'list-unstyled mb-0']);
foreach ($allfeatures as $featurekey => $featurelabel) {
    $active = $ispremium && in_array($featurekey, $status['features'], true);
    $icon   = $active ? '✓' : '✗';
    $cls    = $active ? 'text-success' : 'text-muted';
    echo html_writer::tag('li',
        html_writer::tag('span', $icon . ' ', ['class' => $cls . ' mr-1']) .
        html_writer::tag('span', $featurelabel, ['class' => $active ? '' : 'text-muted']),
        ['class' => 'mb-1']);
}
echo html_writer::end_tag('ul');
echo html_writer::end_div();
echo html_writer::end_div();

// Formulario de clave.
echo html_writer::start_div('card mb-4');
echo html_writer::start_div('card-header');
echo html_writer::tag('h5', get_string('license_enter_key', 'local_smartsmtp'), ['class' => 'mb-0']);
echo html_writer::end_div();
echo html_writer::start_div('card-body');

$saveurl = new moodle_url('/local/smartsmtp/admin/license.php',
    ['action' => 'save', 'sesskey' => sesskey()]);

echo html_writer::start_tag('form', ['method' => 'post', 'action' => $saveurl->out(false)]);
echo html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()]);

echo html_writer::start_div('form-group');
echo html_writer::tag('label', get_string('license_key', 'local_smartsmtp'),
    ['for' => 'license_key', 'class' => 'font-weight-bold']);
echo html_writer::tag('textarea', htmlspecialchars($currentkey), [
    'name'        => 'license_key',
    'id'          => 'license_key',
    'class'       => 'form-control font-monospace',
    'rows'        => '4',
    'placeholder' => get_string('license_key_placeholder', 'local_smartsmtp'),
    'style'       => 'font-size:0.8rem; word-break:break-all;',
]);
echo html_writer::tag('small', get_string('license_key_desc', 'local_smartsmtp'),
    ['class' => 'form-text text-muted']);
echo html_writer::end_div();

echo html_writer::start_div('d-flex gap-2 mt-3');
echo html_writer::tag('button', get_string('license_activate', 'local_smartsmtp'),
    ['type' => 'submit', 'class' => 'btn btn-primary mr-2']);
if (!empty($currentkey)) {
    $clearurl = new moodle_url('/local/smartsmtp/admin/license.php',
        ['action' => 'clear', 'sesskey' => sesskey()]);
    echo html_writer::link($clearurl->out(false),
        get_string('license_clear', 'local_smartsmtp'),
        ['class' => 'btn btn-outline-danger',
         'onclick' => "return confirm('" . get_string('license_clear_confirm', 'local_smartsmtp') . "')"]);
}
echo html_writer::end_div();
echo html_writer::end_tag('form');
echo html_writer::end_div();
echo html_writer::end_div();

if (!$ispremium) {
    echo html_writer::start_div('card border-primary');
    echo html_writer::start_div('card-header bg-primary text-white');
    echo html_writer::tag('h5', get_string('license_get_premium', 'local_smartsmtp'), ['class' => 'mb-0']);
    echo html_writer::end_div();
    echo html_writer::start_div('card-body');
    echo html_writer::tag('p', get_string('license_premium_desc', 'local_smartsmtp'));
    echo html_writer::start_tag('ul');
    foreach ($allfeatures as $label) {
        echo html_writer::tag('li', '✓ ' . $label);
    }
    echo html_writer::end_tag('ul');
    echo html_writer::tag('p', html_writer::tag('strong', get_string('license_price', 'local_smartsmtp')));
    echo html_writer::link(get_string('premium_url', 'local_smartsmtp'),
        get_string('license_buy_now', 'local_smartsmtp') . ' →',
        ['class' => 'btn btn-primary', 'target' => '_blank', 'rel' => 'noopener']);
    echo html_writer::end_div();
    echo html_writer::end_div();
}

echo html_writer::start_div('alert alert-light border mt-4');
echo html_writer::tag('strong', get_string('license_how_works_title', 'local_smartsmtp'));
echo html_writer::tag('p', get_string('license_how_works_desc', 'local_smartsmtp'),
    ['class' => 'mb-0 mt-1 small text-muted']);
echo html_writer::end_div();

echo html_writer::div(
    html_writer::tag('span', '📖 ') .
    html_writer::link(get_string('docs_url', 'local_smartsmtp'),
        get_string('docs_link', 'local_smartsmtp'),
        ['target' => '_blank', 'rel' => 'noopener', 'class' => 'text-muted small']),
    'text-right mt-2'
);

echo $OUTPUT->footer();