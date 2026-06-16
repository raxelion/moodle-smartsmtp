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
 * get logs class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp\external;

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/externallib.php');

/**
 * External API: retrieve email send logs.
 */
class get_logs extends \external_api {
        /**
         * Returns the parameter definitions for this external function.
         */
    public static function execute_parameters(): \external_function_parameters {
        return new \external_function_parameters([
            'account_id' => new \external_value(PARAM_INT, 'Filtrar por buzón, 0 = todos', VALUE_DEFAULT, 0),
            'status'     => new \external_value(PARAM_ALPHA, 'Filtrar por estado', VALUE_DEFAULT, ''),
            'page'       => new \external_value(PARAM_INT, 'Página actual', VALUE_DEFAULT, 0),
            'perpage'    => new \external_value(PARAM_INT, 'Registros por página', VALUE_DEFAULT, 50),
        ]);
    }

        /**
         * Executes the external function and returns log entries.
         */
    public static function execute(int $accountid, string $status, int $page, int $perpage): array {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            'account_id' => $accountid,
            'status'     => $status,
            'page'       => $page,
            'perpage'    => $perpage,
        ]);

        $context = \context_system::instance();
        self::validate_context($context);
        require_capability('local/smartsmtp:viewlogs', $context);

        $where  = '1=1';
        $qparams = [];

        if ($params['account_id']) {
            $where .= ' AND l.account_id = :account_id';
            $qparams['account_id'] = $params['account_id'];
        }
        if ($params['status']) {
            $where .= ' AND l.status = :status';
            $qparams['status'] = $params['status'];
        }

        $total = $DB->count_records_sql(
            "SELECT COUNT(*) FROM {smartsmtp_logs} l WHERE $where",
            $qparams
        );

        $offset = $params['page'] * $params['perpage'];
        $logs   = $DB->get_records_sql("
            SELECT l.*, a.name AS account_name
            FROM {smartsmtp_logs} l
            LEFT JOIN {smartsmtp_accounts} a ON a.id = l.account_id
            WHERE $where
            ORDER BY l.timesent DESC
        ", $qparams, $offset, $params['perpage']);

        $rows = array_map(fn($l) => [
            'id'           => (int)$l->id,
            'account_name' => $l->account_name ?? '',
            'recipient'    => $l->recipient,
            'subject'      => $l->subject,
            'status'       => $l->status,
            'error_msg'    => $l->error_msg ?? '',
            'timesent'     => (int)$l->timesent,
            'timesent_str' => userdate($l->timesent),
        ], array_values($logs));

        return [
            'logs'  => $rows,
            'total' => $total,
        ];
    }

        /**
         * Returns the return value definitions for this external function.
         */
    public static function execute_returns(): \external_single_structure {
        return new \external_single_structure([
            'logs' => new \external_multiple_structure(
                new \external_single_structure([
                    'id'           => new \external_value(PARAM_INT, 'ID del log'),
                    'account_name' => new \external_value(PARAM_TEXT, 'Nombre del buzón'),
                    'recipient'    => new \external_value(PARAM_TEXT, 'Destinatario'),
                    'subject'      => new \external_value(PARAM_TEXT, 'Asunto'),
                    'status'       => new \external_value(PARAM_ALPHA, 'Estado'),
                    'error_msg'    => new \external_value(PARAM_TEXT, 'Error si hubo'),
                    'timesent'     => new \external_value(PARAM_INT, 'Timestamp'),
                    'timesent_str' => new \external_value(PARAM_TEXT, 'Fecha formateada'),
                ])
            ),
            'total' => new \external_value(PARAM_INT, 'Total de registros'),
        ]);
    }
}
