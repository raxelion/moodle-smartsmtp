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
 * save account class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp\external;

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/externallib.php');

/**
 * External API: save an SMTP account.
 */
class save_account extends \external_api {
        /**
         * Returns the parameter definitions for this external function.
         */
    public static function execute_parameters(): \external_function_parameters {
        return new \external_function_parameters([
            'id'            => new \external_value(PARAM_INT, 'ID del buzón, 0 = nuevo'),
            'name'          => new \external_value(PARAM_TEXT, 'Nombre del buzón'),
            'host'          => new \external_value(PARAM_HOST, 'Servidor SMTP'),
            'port'          => new \external_value(PARAM_INT, 'Puerto'),
            'username'      => new \external_value(PARAM_EMAIL, 'Usuario SMTP'),
            'password'      => new \external_value(PARAM_RAW, 'Contraseña (vacío = no cambiar)'),
            'security'      => new \external_value(PARAM_ALPHA, 'Tipo de seguridad'),
            'daily_limit'   => new \external_value(PARAM_INT, 'Límite diario'),
            'is_default'    => new \external_value(PARAM_BOOL, 'Es el buzón por defecto'),
            'enabled'       => new \external_value(PARAM_BOOL, 'Está activo'),
            'noreply_email' => new \external_value(PARAM_EMAIL, 'Email noreply del buzón', VALUE_DEFAULT, ''),
            'noreply_name'  => new \external_value(PARAM_TEXT, 'Nombre visible del remitente', VALUE_DEFAULT, ''),
        ]);
    }

        /**
         * Executes the external function and saves the account.
         */
    public static function execute(
        int $id,
        string $name,
        string $host,
        int $port,
        string $username,
        string $password,
        string $security,
        int $dailylimit,
        bool $isdefault,
        bool $enabled,
        string $noreplyemail = '',
        string $noreplyname = ''
    ): array {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            'id' => $id, 'name' => $name, 'host' => $host,
            'port' => $port, 'username' => $username,
            'password' => $password, 'security' => $security,
            'daily_limit' => $dailylimit, 'is_default' => $isdefault,
            'enabled' => $enabled,
            'noreply_email' => $noreplyemail,
            'noreply_name'  => $noreplyname,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/smartsmtp:manageaccounts', $context);

        if ($params['is_default']) {
            $DB->set_field('smartsmtp_accounts', 'is_default', 0);
        }

        $record = (object)[
            'name'          => $params['name'],
            'host'          => $params['host'],
            'port'          => $params['port'],
            'username'      => $params['username'],
            'security'      => $params['security'],
            'daily_limit'   => $params['daily_limit'],
            'is_default'    => (int)$params['is_default'],
            'enabled'       => (int)$params['enabled'],
            'noreply_email' => $params['noreply_email'],
            'noreply_name'  => $params['noreply_name'],
        ];

        if ($params['id']) {
            $record->id = $params['id'];

            if (!empty($params['password'])) {
                $record->password = \local_smartsmtp\smtp_account::encrypt_password(
                    $params['password']
                );
            }

            $DB->update_record('smartsmtp_accounts', $record);
            $newid = $params['id'];
        } else {
            $record->password    = \local_smartsmtp\smtp_account::encrypt_password(
                $params['password']
            );
            $record->timecreated = time();
            $newid = $DB->insert_record('smartsmtp_accounts', $record);
        }

        return [
            'success'    => true,
            'account_id' => $newid,
            'message'    => get_string(
                $params['id'] ? 'account_updated' : 'account_created',
                'local_smartsmtp'
            ),
        ];
    }

        /**
         * Returns the return value definitions for this external function.
         */
    public static function execute_returns(): \external_single_structure {
        return new \external_single_structure([
            'success'    => new \external_value(PARAM_BOOL, 'Si se guardó correctamente'),
            'account_id' => new \external_value(PARAM_INT, 'ID del buzón guardado'),
            'message'    => new \external_value(PARAM_TEXT, 'Mensaje de confirmación'),
        ]);
    }
}
