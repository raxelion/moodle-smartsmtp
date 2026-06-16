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
 * SmartSMTP — smtp_selector.php
 *
 * Selector base: evalúa reglas por component y opcionalmente por name.
 * Usado en plan free y como clase padre del selector premium.
 *
 * LÓGICA DE RESOLUCIÓN (orden de precedencia, más específica primero):
 *
 *   1. component + name   — solo si la licencia tiene name_granularity
 *                           y se recibió un $name no vacío.
 *   2. component          — regla que coincide solo por componente.
 *   3. Buzón default      — el marcado como is_default = 1.
 *   4. Cualquier buzón    — si no hay default, el primero con capacidad.
 *   5. null               — no hay buzones disponibles con capacidad.
 *
 * LÍMITES FREE:
 *   - Máximo de buzones según el plan (license::get_limits()).
 *   - Máximo de reglas según el plan (license::get_limits()).
 *   - No evalúa el campo name aunque exista en la regla.
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later.
 * @package local_smartsmtp
 */

namespace local_smartsmtp;

/**
 * Selects an SMTP account based on routing rules.
 */
class smtp_selector {
    /**
     * Returns the best account for a given message type.
     */
    public function get_account_for_type(string $component, string $name = ''): ?smtp_account {
        $allowedids = $this->get_allowed_account_ids();

        if (empty($allowedids)) {
            return null;
        }

        if ($name !== '' && license::has_feature(license::FEATURE_NAME_GRANULARITY)) {
            $account = $this->find_by_component_and_name($component, $name, $allowedids);
            if ($account !== null) {
                return $account;
            }
        }

        $account = $this->find_by_component($component, $allowedids);
        if ($account !== null) {
            return $account;
        }

        return $this->get_default_account($allowedids);
    }

    /**
     * Finds a rule matching component and notification name.
     * Iterates all rules by priority until a capable account is found.
     */
    protected function find_by_component_and_name(
        string $component,
        string $name,
        array $allowedids
    ): ?smtp_account {
        global $DB;

        [$insql, $params] = $DB->get_in_or_equal($allowedids);
        $params[] = $component;
        $params[] = $name;

        $rules = $DB->get_records_sql("
            SELECT r.id AS id,
                   a.id AS account_id_val,
                   a.name, a.host, a.port, a.username, a.password,
                   a.security, a.daily_limit, a.is_default, a.enabled,
                   a.timecreated, a.noreply_email, a.noreply_name,
                   r.roundrobin AS rule_roundrobin
              FROM {smartsmtp_rules} r
              JOIN {smartsmtp_accounts} a ON a.id = r.account_id
             WHERE a.id {$insql}
               AND a.enabled   = 1
               AND r.component = ?
               AND r.name      = ?
          ORDER BY r.priority DESC
        ", $params);

        if (empty($rules)) {
            return null;
        }

        foreach ($rules as $rid => &$rule) {
            $rule->id = (int)$rule->account_id_val;
            $account = new smtp_account($rule);
            if ($account->has_capacity()) {
                return $account;
            }
        }
        unset($rule);

        return null;
    }

    /**
     * Finds a rule matching component only.
     * Iterates all rules by priority until a capable account is found.
     */
    protected function find_by_component(
        string $component,
        array $allowedids
    ): ?smtp_account {
        global $DB;

        [$insql, $params] = $DB->get_in_or_equal($allowedids);
        $params[] = $component;

        $rules = $DB->get_records_sql("
            SELECT r.id AS id,
                   a.id AS account_id_val,
                   a.name, a.host, a.port, a.username, a.password,
                   a.security, a.daily_limit, a.is_default, a.enabled,
                   a.timecreated, a.noreply_email, a.noreply_name,
                   r.roundrobin AS rule_roundrobin
              FROM {smartsmtp_rules} r
              JOIN {smartsmtp_accounts} a ON a.id = r.account_id
             WHERE a.id {$insql}
               AND a.enabled   = 1
               AND r.component = ?
               AND r.name      IS NULL
          ORDER BY r.priority DESC
        ", $params);

        if (empty($rules)) {
            $rules = $this->find_all_rules_for_component($component, $allowedids);
        }

        if (empty($rules)) {
            return null;
        }

        foreach ($rules as $rid => &$rule) {
            $rule->id = (int)$rule->account_id_val;
            $account = new smtp_account($rule);
            if ($account->has_capacity()) {
                return $account;
            }
        }
        unset($rule);

        return null;
    }

    /**
     * Finds all rules for a given component ordered by priority.
     */
    private function find_all_rules_for_component(
        string $component,
        array $allowedids
    ): array {
        global $DB;

        [$insql, $params] = $DB->get_in_or_equal($allowedids);
        $params[] = $component;

        $rows = $DB->get_records_sql("
            SELECT r.id AS id,
                   a.id AS account_id_val,
                   a.name, a.host, a.port, a.username, a.password,
                   a.security, a.daily_limit, a.is_default, a.enabled,
                   a.timecreated, a.noreply_email, a.noreply_name,
                   r.roundrobin AS rule_roundrobin
              FROM {smartsmtp_rules} r
              JOIN {smartsmtp_accounts} a ON a.id = r.account_id
             WHERE a.id {$insql}
               AND a.enabled   = 1
               AND r.component = ?
          ORDER BY r.priority DESC
        ", $params) ?: [];

        foreach ($rows as $rid => &$row) {
            $row->id = (int)$row->account_id_val;
        }
        unset($row);

        return $rows;
    }

    /**
     * Returns account IDs allowed by active rules.
     */
    protected function get_allowed_account_ids(): array {
        return array_values(array_map(
            fn($a) => (int)$a->id,
            $this->get_available_accounts()
        ));
    }

    /**
     * Returns available enabled accounts.
     */
    protected function get_available_accounts(): array {
        global $DB;

        return array_values($DB->get_records(
            'smartsmtp_accounts',
            ['enabled' => 1],
            'is_default DESC, id ASC'
        ));
    }

    /**
     * Returns the default account.
     */
    public function get_default_account(array $allowedids = []): ?smtp_account {
        global $DB;

        if (empty($allowedids)) {
            $allowedids = $this->get_allowed_account_ids();
        }

        if (empty($allowedids)) {
            return null;
        }

        [$insql, $params] = $DB->get_in_or_equal($allowedids);

        $record = $DB->get_record_sql("
            SELECT * FROM {smartsmtp_accounts}
             WHERE id {$insql}
               AND enabled    = 1
               AND is_default = 1
             LIMIT 1
        ", $params);

        if (!$record) {
            return $this->get_any_available_account($allowedids);
        }

        $account = new smtp_account($record);
        return $account->has_capacity()
            ? $account
            : $this->get_any_available_account($allowedids);
    }

    /**
     * Returns any available account.
     */
    protected function get_any_available_account(array $allowedids): ?smtp_account {
        global $DB;

        if (empty($allowedids)) {
            return null;
        }

        [$insql, $params] = $DB->get_in_or_equal($allowedids);

        $records = $DB->get_records_sql("
            SELECT * FROM {smartsmtp_accounts}
             WHERE id {$insql}
               AND enabled = 1
          ORDER BY is_default DESC, id ASC
        ", $params);

        foreach ($records as $record) {
            $account = new smtp_account($record);
            if ($account->has_capacity()) {
                return $account;
            }
        }

        return null;
    }

    /**
     * Returns the fallback account when others are unavailable.
     */
    protected function get_fallback_account(
        int $excludeaccountid,
        array $allowedids
    ): ?smtp_account {
        $filtered = array_values(
            array_filter($allowedids, fn($id) => (int)$id !== $excludeaccountid)
        );

        if (empty($filtered)) {
            return null;
        }

        return $this->get_any_available_account($filtered);
    }
}
