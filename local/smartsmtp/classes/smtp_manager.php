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
 * SmartSMTP — smtp_manager.php
 *
 * Selecciona el selector correcto según licencia.
 *
 * SEGURIDAD:
 *   La versión anterior usaba file_exists() para detectar premium.
 *   Eso significa que copiar smtp_selector_pro.php al servidor
 *   activaba el modo premium sin licencia válida.
 *
 *   Ahora la selección depende EXCLUSIVAMENTE de la verificación
 *   RSA en license.php. El archivo smtp_selector_pro.php puede
 *   existir o no — no cambia nada si la licencia no es válida.
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package local_smartsmtp
 */

namespace local_smartsmtp;

/**
 * Selects the appropriate SMTP account for a given message.
 */
class smtp_manager {
    /**
     * Devuelve el selector apropiado según la licencia activa.
     *
     * - Premium con round-robin → smtp_selector_pro (si el archivo existe)
     * - Premium sin round-robin → smtp_selector estándar con límites premium
     * - Free                   → smtp_selector estándar con límites free
     *
     * El archivo smtp_selector_pro.php puede no estar en instalaciones free
     * distribuidas. Si la licencia dice premium pero el archivo no existe,
     * se usa el selector estándar como fallback seguro.
     */
    private function get_selector(): smtp_selector {
        global $CFG;

        // La licencia es la única fuente de verdad — no file_exists().
        $hasroundrobin = license::has_feature(license::FEATURE_ROUND_ROBIN);

        if ($hasroundrobin) {
            $profile = $CFG->dirroot .
                '/local/smartsmtp/classes/premium/smtp_selector_pro.php';

            if (file_exists($profile)) {
                require_once($profile);
                return new \local_smartsmtp\premium\smtp_selector_pro();
            }

            // Premium con round-robin pero sin el archivo — usar estándar.
            // Esto no debería pasar en producción, pero es un fallback seguro.
            debugging(
                'SmartSMTP: licencia con round-robin activo pero ' .
                'smtp_selector_pro.php no encontrado. Usando selector estándar.',
                DEBUG_DEVELOPER
            );
        }

        return new smtp_selector();
    }

    /**
     * Selecciona la cuenta SMTP para el mensaje dado.
     *
     * @param  object          $message  Objeto mensaje de Moodle.
     * @return smtp_account|null         Cuenta a usar, o null si no hay disponible.
     */
        /**
         * Returns the best SMTP account for the given message.
         */
    public function select_account_for(object $message): ?smtp_account {
        $selector  = $this->get_selector();
        $component = $this->detect_component($message);
        $name      = $this->detect_name($message);

        // El selector pro tiene get_account_round_robin con firma extendida.
        // El selector estándar tiene get_account_for_type.
        if (method_exists($selector, 'get_account_round_robin')) {
            return $selector->get_account_round_robin($component, $name);
        }

        return $selector->get_account_for_type($component, $name);
    }

    /**
     * Extrae el component del mensaje.
     * Equivale al plugin Moodle que generó la notificación.
     * Ejemplos: mod_forum, mod_assign, moodle, core_badges.
     */
    private function detect_component(object $message): string {
        if (!empty($message->component)) {
            return $message->component;
        }
        return 'moodle';
    }

    /**
     * Extrae el name del mensaje (granularidad fina, solo usada en premium).
     * Ejemplos: 'posts' en mod_forum, 'due_date' en mod_assign.
     */
    private function detect_name(object $message): string {
        if (!empty($message->name)) {
            return $message->name;
        }
        if (!empty($message->eventtype)) {
            return $message->eventtype;
        }
        return '';
    }
}
