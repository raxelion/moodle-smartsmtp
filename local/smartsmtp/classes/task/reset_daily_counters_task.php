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
 * reset daily counters task class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 */

namespace local_smartsmtp\task;

/**
 * Scheduled task: reset daily email send counters.
 */
class reset_daily_counters_task extends \core\task\scheduled_task {
        /**
         * Returns the task display name.
         */
    public function get_name(): string {
        return get_string('task_reset_counters', 'local_smartsmtp');
    }

        /**
         * Executes the task.
         */
    public function execute(): void {
        global $DB;

        // Eliminar registros de días anteriores de la tabla BD.
        $yesterday = date('Ymd', strtotime('yesterday'));
        $DB->delete_records_select(
            'smartsmtp_daily_counts',
            'day <= :yesterday',
            ['yesterday' => $yesterday]
        );

        // Limpiar también la caché de Moodle.
        $cache = \cache::make('local_smartsmtp', 'daily_counts');
        $cache->purge();

        mtrace('SmartSMTP: contadores diarios reseteados.');
    }
}
