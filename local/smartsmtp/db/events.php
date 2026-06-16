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
 * Event observers definition.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die();

$observers = [
    // Limpiar caché de contadores al inicio del día.
    [
        'eventname'   => '\core\event\cron_executed',
        'callback'    => '\local_smartsmtp\event_observer::on_cron_executed',
        'includefile' => null,
        'internal'    => false,
        'priority'    => 200,
    ],
    // Registrar cuando un usuario cambia su email (para logs).
    [
        'eventname'   => '\core\event\user_updated',
        'callback'    => '\local_smartsmtp\event_observer::on_user_updated',
        'internal'    => false,
        'priority'    => 100,
    ],
    [
        'eventname'   => '\core\event\email_failed',
        'callback'    => '\local_smartsmtp\event_observer::email_failed',
        'includefile' => null,
        'internal'    => false,
        'priority'    => 200,
    ],
];
