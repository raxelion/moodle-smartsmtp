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
 * Plugin settings.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_category(
        'local_smartsmtp_category',
        get_string('pluginname', 'local_smartsmtp')
    ));

    // Buzones SMTP — archivo en raíz del plugin.
    $ADMIN->add('local_smartsmtp_category', new admin_externalpage(
        'local_smartsmtp_accounts',
        get_string('manage_accounts', 'local_smartsmtp'),
        new moodle_url('/local/smartsmtp/admin/accounts.php'),
        'local/smartsmtp:manageaccounts'
    ));

    // Reglas de enrutamiento.
    $ADMIN->add('local_smartsmtp_category', new admin_externalpage(
        'local_smartsmtp_rules',
        get_string('manage_rules', 'local_smartsmtp'),
        new moodle_url('/local/smartsmtp/admin/rules.php'),
        'local/smartsmtp:manageaccounts'
    ));

    // Logs de envíos.
    $ADMIN->add('local_smartsmtp_category', new admin_externalpage(
        'local_smartsmtp_logs',
        get_string('email_logs', 'local_smartsmtp'),
        new moodle_url('/local/smartsmtp/admin/logs.php'),
        'local/smartsmtp:viewlogs'
    ));

    // Licencia premium.
    $ADMIN->add('local_smartsmtp_category', new admin_externalpage(
        'local_smartsmtp_license',
        get_string('license_management', 'local_smartsmtp'),
        new moodle_url('/local/smartsmtp/admin/license.php'),
        'local/smartsmtp:manageaccounts'
    ));

    // Configuración general.
    $settings = new admin_settingpage(
        'local_smartsmtp_settings',
        get_string('general_settings', 'local_smartsmtp')
    );

    $settings->add(new admin_setting_configtext(
        'local_smartsmtp/log_retention_days',
        get_string('log_retention_days', 'local_smartsmtp'),
        get_string('log_retention_days_desc', 'local_smartsmtp'),
        '90',
        PARAM_INT
    ));

    $settings->add(new admin_setting_configcheckbox(
        'local_smartsmtp/debug_mode',
        get_string('debug_mode', 'local_smartsmtp'),
        get_string('debug_mode_desc', 'local_smartsmtp'),
        0
    ));

    $ADMIN->add('local_smartsmtp_category', $settings);
}
