<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify.
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,.
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the.
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License.
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * External services definition.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'local_smartsmtp_test_connection' => [
        'classname'     => '\local_smartsmtp\external\test_connection',
        'methodname'    => 'execute',
        'description'   => 'Prueba la conexión de un buzón SMTP',
        'type'          => 'write',
        'capabilities'  => 'local/smartsmtp:manageaccounts',
        'ajax'          => true, // Disponible vía AJAX.
        'loginrequired' => true,
    ],
    'local_smartsmtp_get_logs' => [
        'classname'     => '\local_smartsmtp\external\get_logs',
        'methodname'    => 'execute',
        'description'   => 'Obtiene logs paginados de envíos',
        'type'          => 'read',
        'capabilities'  => 'local/smartsmtp:viewlogs',
        'ajax'          => true,
        'loginrequired' => true,
    ],
    'local_smartsmtp_save_account' => [
        'classname'     => '\local_smartsmtp\external\save_account',
        'methodname'    => 'execute',
        'description'   => 'Guarda o actualiza un buzón SMTP',
        'type'          => 'write',
        'capabilities'  => 'local/smartsmtp:manageaccounts',
        'ajax'          => true,
        'loginrequired' => true,
    ],
];
