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
 * Upgrade steps for message_smartsmtp.
 *
 * @package    message_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Upgrade steps for message_smartsmtp.
 *
 * @param int $oldversion Previous plugin version.
 * @return bool
 * @package message_smartsmtp
 */
function xmldb_message_smartsmtp_upgrade($oldversion): bool {
    global $DB;

    if ($oldversion < 2026050400) {
        $DB->set_field('message_processors', 'available', 1, ['name' => 'smartsmtp']);

        $providers = $DB->get_records('message_providers');
        foreach ($providers as $provider) {
            $base = 'smartsmtp_provider_' . $provider->component . '_' . $provider->name;
            foreach (['_locked' => '0', '_enabled' => '1'] as $suffix => $default) {
                $key = $base . $suffix;
                if (!$DB->record_exists('config_plugins', ['plugin' => 'message', 'name' => $key])) {
                    $DB->insert_record('config_plugins', (object)[
                        'plugin' => 'message',
                        'name'   => $key,
                        'value'  => $default,
                    ]);
                }
            }
        }

        $enableddefaults = $DB->get_records_select(
            'config_plugins',
            "plugin = 'message' AND name LIKE '%\\_enabled' AND " .
            $DB->sql_like('value', ':val'),
            ['val' => '%email%']
        );
        foreach ($enableddefaults as $config) {
            $newvalue = str_replace('email', 'smartsmtp', $config->value);
            if ($newvalue !== $config->value) {
                $DB->set_field('config_plugins', 'value', $newvalue, ['id' => $config->id]);
            }
        }

        upgrade_plugin_savepoint(true, 2026050400, 'message', 'smartsmtp');
    }

    return true;
}
