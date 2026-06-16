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
 * account form class.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_smartsmtp\forms;
defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->libdir . '/formslib.php');

/**
 * SMTP account edit form.
 */
class account_form extends \moodleform {
        /**
         * Defines the form fields.
         */
    public function definition(): void {
        $mform  = $this->_form;
        $record = $this->_customdata['record'] ?? new \stdClass();

        $mform->addElement('hidden', 'id', $record->id ?? 0);
        $mform->setType('id', PARAM_INT);

        $mform->addElement(
            'header',
            'header_basic',
            get_string('account_basic', 'local_smartsmtp')
        );

        $mform->addElement(
            'text',
            'name',
            get_string('account_name', 'local_smartsmtp')
        );
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required');

        $mform->addElement(
            'advcheckbox',
            'enabled',
            get_string('enabled', 'local_smartsmtp')
        );
        $mform->setDefault('enabled', 1);

        $mform->addElement(
            'advcheckbox',
            'is_default',
            get_string('set_as_default', 'local_smartsmtp')
        );
        $mform->addHelpButton('is_default', 'set_as_default', 'local_smartsmtp');

        $mform->addElement(
            'header',
            'header_smtp',
            get_string('smtp_settings', 'local_smartsmtp')
        );

        $mform->addElement(
            'text',
            'host',
            get_string('smtp_host', 'local_smartsmtp')
        );
        $mform->setType('host', PARAM_HOST);
        $mform->addRule('host', null, 'required');
        $mform->addHelpButton('host', 'smtp_host', 'local_smartsmtp');

        $mform->addElement(
            'text',
            'port',
            get_string('smtp_port', 'local_smartsmtp')
        );
        $mform->setType('port', PARAM_INT);
        $mform->setDefault('port', 587);
        $mform->addRule('port', null, 'required');
        $mform->addHelpButton('port', 'smtp_port', 'local_smartsmtp');

        $mform->addElement(
            'select',
            'security',
            get_string('smtp_security', 'local_smartsmtp'),
            [
                ''    => get_string('security_none', 'local_smartsmtp'),
                'ssl' => 'SSL',
                'tls' => 'TLS',
            ]
        );
        $mform->setDefault('security', 'tls');
        $mform->addHelpButton('security', 'smtp_security', 'local_smartsmtp');

        $mform->addElement(
            'header',
            'header_auth',
            get_string('smtp_auth', 'local_smartsmtp')
        );

        $mform->addElement(
            'text',
            'username',
            get_string('smtp_username', 'local_smartsmtp')
        );
        $mform->setType('username', PARAM_RAW_TRIMMED);
        $mform->addRule('username', null, 'required');
        $mform->addHelpButton('username', 'smtp_username', 'local_smartsmtp');

        $passlabel = !empty($record->id)
            ? get_string('smtp_password_change', 'local_smartsmtp')
            : get_string('smtp_password', 'local_smartsmtp');

        $mform->addElement('passwordunmask', 'password_new', $passlabel);
        $mform->setType('password_new', PARAM_RAW);

        if (!empty($record->id)) {
            $mform->addElement(
                'static',
                'password_hint',
                '',
                get_string('password_leave_blank', 'local_smartsmtp')
            );
        } else {
            $mform->addRule('password_new', null, 'required');
        }

        $mform->addElement(
            'header',
            'header_noreply',
            get_string('noreply_settings', 'local_smartsmtp')
        );

        $mform->addElement(
            'text',
            'noreply_email',
            get_string('noreply_email', 'local_smartsmtp')
        );
        $mform->setType('noreply_email', PARAM_EMAIL);
        $mform->addHelpButton('noreply_email', 'noreply_email', 'local_smartsmtp');

        $mform->addElement(
            'text',
            'noreply_name',
            get_string('noreply_name', 'local_smartsmtp')
        );
        $mform->setType('noreply_name', PARAM_TEXT);
        $mform->addHelpButton('noreply_name', 'noreply_name', 'local_smartsmtp');

        $mform->addElement(
            'static',
            'noreply_note',
            '',
            get_string('noreply_note', 'local_smartsmtp')
        );

        $mform->addElement(
            'header',
            'header_limits',
            get_string('sending_limits', 'local_smartsmtp')
        );

        $mform->addElement(
            'text',
            'daily_limit',
            get_string('daily_limit', 'local_smartsmtp')
        );
        $mform->setType('daily_limit', PARAM_INT);
        $mform->setDefault('daily_limit', 500);
        $mform->addHelpButton('daily_limit', 'daily_limit', 'local_smartsmtp');

        $mform->addElement(
            'header',
            'header_notes',
            get_string('notes', 'local_smartsmtp')
        );

        $mform->addElement(
            'textarea',
            'notes',
            get_string('account_notes', 'local_smartsmtp'),
            ['rows' => 3]
        );
        $mform->setType('notes', PARAM_TEXT);

        if (!empty($record->id)) {
            $mform->setDefault('name', $record->name);
            $mform->setDefault('host', $record->host);
            $mform->setDefault('port', $record->port);
            $mform->setDefault('security', $record->security);
            $mform->setDefault('username', $record->username);
            $mform->setDefault('daily_limit', $record->daily_limit);
            $mform->setDefault('enabled', $record->enabled);
            $mform->setDefault('is_default', $record->is_default);
            $mform->setDefault('notes', $record->notes ?? '');
            $mform->setDefault('noreply_email', $record->noreply_email ?? '');
            $mform->setDefault('noreply_name', $record->noreply_name ?? '');
        }

        $this->add_action_buttons();
    }

        /**
         * Validates the form data.
         */
    public function validation($data, $files): array {
        $errors = parent::validation($data, $files);

        if (!empty($data['port']) && ($data['port'] < 1 || $data['port'] > 65535)) {
            $errors['port'] = get_string('invalid_port', 'local_smartsmtp');
        }
        if (isset($data['daily_limit']) && (int)$data['daily_limit'] < 0) {
            $errors['daily_limit'] = get_string('invalid_limit', 'local_smartsmtp');
        }
        if (isset($data['daily_limit']) && (int)$data['daily_limit'] === 0) {
            if (!\local_smartsmtp\license::is_premium()) {
                $errors['daily_limit'] = get_string('premium_required', 'local_smartsmtp');
            }
        }
        if (!empty($data['noreply_email']) && !validate_email($data['noreply_email'])) {
            $errors['noreply_email'] = get_string('invalidemail');
        }
        return $errors;
    }
}
