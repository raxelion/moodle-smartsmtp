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
 * test connection class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp\external;

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/externallib.php');

/**
 * External API: test an SMTP account connection.
 */
class test_connection extends \external_api {
        /**
         * Returns the parameter definitions for this external function.
         */
    public static function execute_parameters(): \external_function_parameters {
        return new \external_function_parameters([
            'account_id' => new \external_value(PARAM_INT, 'ID del buzón a probar'),
            'to_email'   => new \external_value(PARAM_EMAIL, 'Email de destino para la prueba'),
        ]);
    }

        /**
         * Executes the connection test and returns the result.
         */
    public static function execute(int $accountid, string $toemail): array {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            'account_id' => $accountid,
            'to_email'   => $toemail,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/smartsmtp:manageaccounts', $context);

        $record = $DB->get_record(
            'smartsmtp_accounts',
            ['id' => $params['account_id']],
            '*',
            MUST_EXIST
        );

        $task = new \local_smartsmtp\task\send_test_task();
        $task->set_custom_data([
            'account_id' => $params['account_id'],
            'to_email'   => $params['to_email'],
        ]);
        \core\task\manager::queue_adhoc_task($task);

        return [
            'success' => true,
            'message' => get_string('test_queued', 'local_smartsmtp'),
            'error'   => '',
        ];
    }

        /**
         * Returns the return value definitions for this external function.
         */
    public static function execute_returns(): \external_single_structure {
        return new \external_single_structure([
            'success' => new \external_value(PARAM_BOOL, 'Si la tarea se encoló correctamente'),
            'message' => new \external_value(PARAM_TEXT, 'Mensaje de respuesta'),
            'error'   => new \external_value(PARAM_TEXT, 'Mensaje de error si falló'),
        ]);
    }
}
