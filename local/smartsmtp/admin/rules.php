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
 * Routing rules management page.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */require_once('../../../config.php');
require_login();

$context = context_system::instance();
require_capability('local/smartsmtp:manageaccounts', $context);

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/smartsmtp/admin/rules.php'));
$PAGE->set_title(get_string('manage_rules', 'local_smartsmtp'));
$PAGE->set_heading(get_string('manage_rules', 'local_smartsmtp'));
$PAGE->set_pagelayout('admin');

global $DB, $OUTPUT;

$ispremium     = \local_smartsmtp\license::is_premium();
$hasnamegran  = \local_smartsmtp\license::has_feature(\local_smartsmtp\license::FEATURE_NAME_GRANULARITY);
$hasroundrobin = \local_smartsmtp\license::has_feature(\local_smartsmtp\license::FEATURE_ROUND_ROBIN);

$components = [
    ''              => get_string('rule_component_any', 'local_smartsmtp'),
    'mod_forum'     => 'mod_forum — '     . get_string('rule_comp_forum', 'local_smartsmtp'),
    'mod_assign'    => 'mod_assign — '    . get_string('rule_comp_assign', 'local_smartsmtp'),
    'mod_quiz'      => 'mod_quiz — '      . get_string('rule_comp_quiz', 'local_smartsmtp'),
    'mod_workshop'  => 'mod_workshop — '  . get_string('rule_comp_workshop', 'local_smartsmtp'),
    'mod_data'      => 'mod_data — '      . get_string('rule_comp_data', 'local_smartsmtp'),
    'mod_lesson'    => 'mod_lesson — '    . get_string('rule_comp_lesson', 'local_smartsmtp'),
    'mod_feedback'  => 'mod_feedback — '  . get_string('rule_comp_feedback', 'local_smartsmtp'),
    'mod_chat'      => 'mod_chat — '      . get_string('rule_comp_chat', 'local_smartsmtp'),
    'core_badges'   => 'core_badges — '   . get_string('rule_comp_badges', 'local_smartsmtp'),
    'core_calendar' => 'core_calendar — ' . get_string('rule_comp_calendar', 'local_smartsmtp'),
    'core_message'  => 'core_message — '  . get_string('rule_comp_message', 'local_smartsmtp'),
    'enrol_self'    => 'enrol_self — '    . get_string('rule_comp_enrol_self', 'local_smartsmtp'),
    'enrol_manual'  => 'enrol_manual — '  . get_string('rule_comp_enrol_manual', 'local_smartsmtp'),
    'tool_monitor'  => 'tool_monitor — '  . get_string('rule_comp_monitor', 'local_smartsmtp'),
    'analytics'     => 'analytics — '     . get_string('rule_comp_analytics', 'local_smartsmtp'),
];

$action  = optional_param('action', '', PARAM_ALPHA);
$ruleid = optional_param('id', 0, PARAM_INT);

if ($action && confirm_sesskey()) {
    if ($action === 'delete' && $ruleid) {
        $DB->delete_records('smartsmtp_rules', ['id' => $ruleid]);
        redirect(
            $PAGE->url,
            get_string('rule_deleted', 'local_smartsmtp'),
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    }

    if ($action === 'add') {
        if (!$ispremium) {
            $count = $DB->count_records('smartsmtp_rules');
            if (!\local_smartsmtp\license::can_add_rule($count)) {
                redirect(
                    $PAGE->url,
                    get_string('max_rules_reached', 'local_smartsmtp'),
                    null,
                    \core\output\notification::NOTIFY_ERROR
                );
            }
        }

        $component  = optional_param('component', '', PARAM_TEXT);
        $accountid = required_param('account_id', PARAM_INT);
        $priority   = optional_param('priority', 0, PARAM_INT);
        $name       = $hasnamegran ? trim(optional_param('name', '', PARAM_TEXT)) : '';
        $roundrobin = $hasroundrobin ? (optional_param('roundrobin', 0, PARAM_INT) ? 1 : 0) : 0;

        $notificationtype = $component ?: 'general';

        $where  = 'account_id = :account_id';
        $params = ['account_id' => $accountid];
        if ($component !== '') {
            $where .= ' AND component = :component';
            $params['component'] = $component;
        } else {
            $where .= ' AND component IS NULL';
        }
        if ($name !== '') {
            $where .= ' AND name = :name';
            $params['name'] = $name;
        } else {
            $where .= ' AND name IS NULL';
        }

        $existing = $DB->get_record_select('smartsmtp_rules', $where, $params);

        if ($existing) {
            $existing->priority          = $priority;
            $existing->roundrobin        = $roundrobin;
            $existing->notification_type = $notificationtype;
            $DB->update_record('smartsmtp_rules', $existing);
        } else {
            $DB->insert_record('smartsmtp_rules', (object)[
                'notification_type' => $notificationtype,
                'component'         => $component !== '' ? $component : null,
                'name'              => $name !== '' ? $name : null,
                'account_id'        => $accountid,
                'priority'          => $priority,
                'roundrobin'        => $roundrobin,
                'roundrobin_index'  => 0,
            ]);
        }

        redirect(
            $PAGE->url,
            get_string('rule_added', 'local_smartsmtp'),
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    }
}

$rules = $DB->get_records_sql("
    SELECT r.*, a.name AS account_name
      FROM {smartsmtp_rules} r
      JOIN {smartsmtp_accounts} a ON a.id = r.account_id
  ORDER BY r.priority DESC, r.component ASC, r.name ASC
");

$accounts      = $DB->get_records_menu('smartsmtp_accounts', ['enabled' => 1], 'name ASC', 'id, name');
$currentcount = count($rules);
$canaddmore  = \local_smartsmtp\license::can_add_rule($currentcount);

echo $OUTPUT->header();

$planbadge  = $ispremium
    ? '<span class="badge badge-success px-2">Premium</span>'
    : '<span class="badge badge-secondary px-2">Free</span>';
$counterstr = $ispremium
    ? get_string('rules_count_premium', 'local_smartsmtp', $currentcount)
    : get_string(
        'rules_count_free',
        'local_smartsmtp',
        (object)['current' => $currentcount, 'max' => \local_smartsmtp\license::get_limits()['max_rules']]
    );

echo html_writer::div(
    $planbadge . ' ' . html_writer::tag('span', $counterstr, ['class' => 'ml-2 text-muted small']),
    'alert alert-light border mb-3 d-flex align-items-center'
);

if (!\local_smartsmtp\license::can_add_rule($currentcount)) {
    $upgradeurl = new moodle_url('/local/smartsmtp/admin/license.php');
    echo html_writer::div(
        get_string('max_rules_reached_detail', 'local_smartsmtp') . ' ' .
        html_writer::link(
            $upgradeurl,
            get_string('upgrade_to_premium', 'local_smartsmtp'),
            ['class' => 'alert-link']
        ),
        'alert alert-warning'
    );
}

echo $OUTPUT->heading(get_string('current_rules', 'local_smartsmtp'), 3);

if (empty($rules)) {
    echo $OUTPUT->notification(get_string('no_rules_yet', 'local_smartsmtp'), 'info');
} else {
    $table             = new html_table();
    $table->head       = [
        get_string('rule_component', 'local_smartsmtp'),
        get_string('rule_name_field', 'local_smartsmtp'),
        get_string('rule_account', 'local_smartsmtp'),
        get_string('rule_priority', 'local_smartsmtp'),
        get_string('rule_roundrobin', 'local_smartsmtp'),
        get_string('delete'),
    ];
    $table->attributes = ['class' => 'admintable generaltable'];

    foreach ($rules as $rule) {
        $complabel = $components[$rule->component ?? '']
            ?? ($rule->component ?: get_string('rule_component_any', 'local_smartsmtp'));

        $namecell = !empty($rule->name)
            ? html_writer::tag('code', htmlspecialchars($rule->name)) .
              (!$ispremium ? ' ' . html_writer::tag(
                  'span',
                  get_string('premium_only_short', 'local_smartsmtp'),
                  ['class' => 'badge badge-warning']
              ) : '')
            : html_writer::tag('span', '—', ['class' => 'text-muted']);

        $rrcell = !empty($rule->roundrobin)
            ? html_writer::tag('span', '✓', ['class' => 'badge badge-info'])
            : html_writer::tag('span', '—', ['class' => 'text-muted']);

        $deleteurl = new moodle_url('/local/smartsmtp/admin/rules.php', [
            'action' => 'delete', 'id' => $rule->id, 'sesskey' => sesskey(),
        ]);

        $table->data[] = [
            htmlspecialchars($complabel), $namecell,
            format_string($rule->account_name), $rule->priority,
            $rrcell,
            html_writer::link(
                $deleteurl,
                get_string('delete'),
                ['class' => 'btn btn-sm btn-outline-danger']
            ),
        ];
    }
    echo html_writer::table($table);
}

echo $OUTPUT->heading(get_string('add_rule', 'local_smartsmtp'), 3);

if (empty($accounts)) {
    echo $OUTPUT->notification(get_string('need_account_for_rules', 'local_smartsmtp'), 'warning');
} else if (!$canaddmore) {
    echo $OUTPUT->notification(get_string('max_rules_reached', 'local_smartsmtp'), 'warning');
} else {
    $componentoptions = '';
    foreach ($components as $val => $lbl) {
        $componentoptions .= html_writer::tag('option', htmlspecialchars($lbl), ['value' => $val]);
    }
    $accountoptions = '';
    foreach ($accounts as $aid => $aname) {
        $accountoptions .= html_writer::tag('option', format_string($aname), ['value' => $aid]);
    }

    $addurl = new moodle_url(
        '/local/smartsmtp/admin/rules.php',
        ['action' => 'add', 'sesskey' => sesskey()]
    );

    echo html_writer::start_tag('form', ['method' => 'post', 'action' => $addurl->out(false), 'class' => 'mt-3']);
    echo html_writer::empty_tag('input', ['type' => 'hidden', 'name' => 'sesskey', 'value' => sesskey()]);
    echo html_writer::start_div('card');
    echo html_writer::start_div('card-body');

    echo html_writer::start_div('form-group row mb-3');
    echo html_writer::tag(
        'label',
        get_string('rule_component', 'local_smartsmtp'),
        ['class' => 'col-sm-3 col-form-label', 'for' => 'component']
    );
    echo html_writer::start_div('col-sm-9');
    echo html_writer::tag(
        'select',
        $componentoptions,
        ['name' => 'component', 'id' => 'component', 'class' => 'form-control custom-select']
    );
    echo html_writer::tag(
        'small',
        get_string('rule_component_help', 'local_smartsmtp'),
        ['class' => 'form-text text-muted']
    );
    echo html_writer::tag(
        'div',
        '⚠ ' . get_string('non_interceptable_title', 'local_smartsmtp') . ' ' .
        get_string('non_interceptable_desc', 'local_smartsmtp'),
        ['class' => 'alert alert-warning py-1 px-2 mt-1 small mb-0']
    );
    echo html_writer::end_div();
    echo html_writer::end_div();

    $namelbl = get_string('rule_name_field', 'local_smartsmtp');
    if (!$hasnamegran) {
        $namelbl .= ' ' . html_writer::tag(
            'span',
            get_string('premium_badge', 'local_smartsmtp'),
            ['class' => 'badge badge-warning ml-1']
        );
    }
    $nameattrs = ['type' => 'text', 'name' => 'name', 'id' => 'name',
        'class' => 'form-control', 'maxlength' => '100',
        'placeholder' => get_string('rule_name_placeholder', 'local_smartsmtp')];
    if (!$hasnamegran) {
        $nameattrs['disabled'] = 'disabled';
        $nameattrs['title']    = get_string('premium_required', 'local_smartsmtp');
    }
    echo html_writer::start_div('form-group row mb-3' . (!$hasnamegran ? ' smartsmtp-premium-field' : ''));
    echo html_writer::tag('label', $namelbl, ['class' => 'col-sm-3 col-form-label', 'for' => 'name']);
    echo html_writer::start_div('col-sm-9');
    echo html_writer::empty_tag('input', $nameattrs);
    echo html_writer::tag(
        'small',
        $hasnamegran ? get_string('rule_name_help', 'local_smartsmtp') : get_string('rule_name_help_free', 'local_smartsmtp'),
        ['class' => 'form-text text-muted']
    );
    echo html_writer::end_div();
    echo html_writer::end_div();

    echo html_writer::start_div('form-group row mb-3');
    echo html_writer::tag(
        'label',
        get_string('rule_account', 'local_smartsmtp'),
        ['class' => 'col-sm-3 col-form-label', 'for' => 'account_id']
    );
    echo html_writer::start_div('col-sm-9');
    echo html_writer::tag(
        'select',
        $accountoptions,
        ['name' => 'account_id', 'id' => 'account_id', 'class' => 'form-control custom-select']
    );
    echo html_writer::end_div();
    echo html_writer::end_div();

    // Prioridad.
    echo html_writer::start_div('form-group row mb-3');
    echo html_writer::tag(
        'label',
        get_string('rule_priority', 'local_smartsmtp'),
        ['class' => 'col-sm-3 col-form-label', 'for' => 'priority']
    );
    echo html_writer::start_div('col-sm-9');
    echo html_writer::empty_tag('input', ['type' => 'number', 'name' => 'priority', 'id' => 'priority',
        'value' => '0', 'min' => '0', 'max' => '100', 'class' => 'form-control', 'style' => 'max-width:120px']);
    echo html_writer::tag(
        'small',
        get_string('priority_help', 'local_smartsmtp'),
        ['class' => 'form-text text-muted']
    );
    echo html_writer::end_div();
    echo html_writer::end_div();

    $rrlbl = get_string('rule_roundrobin', 'local_smartsmtp');
    if (!$hasroundrobin) {
        $rrlbl .= ' ' . html_writer::tag(
            'span',
            get_string('premium_badge', 'local_smartsmtp'),
            ['class' => 'badge badge-warning ml-1']
        );
    }
    $rrattrs = ['type' => 'checkbox', 'name' => 'roundrobin', 'id' => 'roundrobin', 'value' => '1', 'class' => 'mr-2'];
    if (!$hasroundrobin) {
        $rrattrs['disabled'] = 'disabled';
        $rrattrs['title']    = get_string('premium_required', 'local_smartsmtp');
    }
    echo html_writer::start_div('form-group row mb-3' . (!$hasroundrobin ? ' smartsmtp-premium-field' : ''));
    echo html_writer::tag('label', $rrlbl, ['class' => 'col-sm-3 col-form-label', 'for' => 'roundrobin']);
    echo html_writer::start_div('col-sm-9 d-flex align-items-center');
    echo html_writer::empty_tag('input', $rrattrs);
    echo html_writer::tag(
        'small',
        $hasroundrobin
            ? get_string('rule_roundrobin_help', 'local_smartsmtp')
            : get_string('rule_roundrobin_help_free', 'local_smartsmtp'),
        ['class' => 'text-muted']
    );
    echo html_writer::end_div();
    echo html_writer::end_div();

    echo html_writer::start_div('form-group row');
    echo html_writer::start_div('col-sm-9 offset-sm-3');
    echo html_writer::tag(
        'button',
        get_string('add_rule', 'local_smartsmtp'),
        ['type' => 'submit', 'class' => 'btn btn-primary']
    );
    echo html_writer::end_div();
    echo html_writer::end_div();

    echo html_writer::end_div();
    echo html_writer::end_div();
    echo html_writer::end_tag('form');

    echo html_writer::tag('style', '
        .smartsmtp-premium-field{opacity:.6}
        .smartsmtp-premium-field input,.smartsmtp-premium-field select{cursor:not-allowed;background:#f8f9fa}
    ');
}

echo html_writer::div(
    html_writer::tag('strong', get_string('non_interceptable_title', 'local_smartsmtp')) .
    ' ' . get_string('non_interceptable_desc', 'local_smartsmtp'),
    'alert alert-secondary mt-4'
);

echo html_writer::div(
    html_writer::tag('span', '📖 ', []) .
    html_writer::link(
        get_string('docs_url', 'local_smartsmtp'),
        get_string('docs_link', 'local_smartsmtp'),
        ['target' => '_blank', 'rel' => 'noopener', 'class' => 'text-muted small']
    ),
    'text-right mt-2'
);

echo $OUTPUT->footer();
