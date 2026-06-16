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
 * German language strings.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['account']               = 'Konto';
$string['account_basic']         = 'Kontoidentifikation';
$string['account_created']       = 'Konto erfolgreich erstellt';
$string['account_deleted']       = 'Konto erfolgreich gelöscht';
$string['account_name']          = 'Kontoname';
$string['account_notes']         = 'Interne Notizen';
$string['account_updated']       = 'Konto erfolgreich aktualisiert';
$string['add_account']           = 'SMTP-Konto hinzufügen';
$string['add_rule']              = 'Regel hinzufügen';
$string['all_accounts']          = 'Alle Konten';
$string['all_statuses']          = 'Alle Status';
$string['confirm_delete']        = 'Möchten Sie dieses Konto wirklich löschen?';
$string['current_rules']             = 'Aktuelle Regeln';
$string['daily_limit']           = 'Tägliches Versandlimit';
$string['daily_limit_help']      = 'Maximale E-Mails pro Tag. 0 für unbegrenzt (nur Premium).';
$string['debug_mode']            = 'Debug-Modus';
$string['debug_mode_desc']       = 'Detaillierte SmartSMTP-Aktivität im Moodle-Debug protokollieren. In der Produktion deaktivieren.';
$string['default']               = 'Standard';
$string['disabled']              = 'Deaktiviert';
$string['docs_link']             = 'Vollständige Dokumentation auf raxelion.com';
$string['docs_url']              = 'https://raxelion.com/smartsmtp/docs';
$string['edit_account']          = 'SMTP-Konto bearbeiten';
$string['edit_blocked_reduce_accounts'] = 'Ihre Premium-Lizenz ist abgelaufen. Um Postfächer zu bearbeiten, reduzieren Sie die Anzahl auf {$a} oder weniger.';
$string['email_logs']            = 'E-Mail-Versandprotokoll';
$string['emails_today']          = 'E-Mails heute';
$string['enabled']               = 'Aktiviert';
$string['error']                 = 'Fehler';
$string['error_all_full']        = 'Alle SMTP-Konten haben ihr tägliches Versandlimit erreicht.';
$string['error_no_account']      = 'Kein SMTP-Konto verfügbar. Konfigurieren Sie mindestens ein Konto.';
$string['feature_name_granularity']    = 'Granularität nach Benachrichtigungsname';
$string['feature_roundrobin']          = 'Round-Robin zwischen Postfächern';
$string['feature_unlimited_mailboxes'] = 'Unbegrenzte SMTP-Postfächer';
$string['feature_unlimited_rules']     = 'Unbegrenzte Weiterleitungsregeln';
$string['free_banner_desc']            = 'Kostenlose Version: {$a->current} von {$a->max} Konten verwendet.';
$string['general_settings']      = 'Allgemeine Einstellungen';
$string['invalid_limit']         = 'Das tägliche Limit muss 0 oder größer sein.';
$string['invalid_port']          = 'Der Port muss eine Zahl zwischen 1 und 65535 sein.';
$string['license_activate']          = 'Aktivieren';
$string['license_activated']         = 'Lizenz erfolgreich aktiviert.';
$string['license_buy_now']           = 'Jetzt kaufen';
$string['license_clear']             = 'Lizenz entfernen';
$string['license_clear_confirm']     = 'Sie kehren zum kostenlosen Plan zurück. Fortfahren?';
$string['license_cleared']           = 'Lizenz entfernt. Sie befinden sich jetzt im kostenlosen Plan.';
$string['license_days_left']            = 'Noch {$a} Tage';
$string['license_domain']            = 'Lizenzierte Domain';
$string['license_enter_key']         = 'Lizenz aktivieren';
$string['license_expired_accounts_desc'] = 'Ihre Lizenz ist abgelaufen und Sie haben {$a->count} Postfächer konfiguriert (Limit: {$a->max}). Die Bearbeitung ist gesperrt, bis Sie auf {$a->max} oder weniger reduzieren oder Ihre Lizenz erneuern.';
$string['license_expired_desc']         = 'Ihre Premium-Lizenz ist abgelaufen. Das Plugin ist zum kostenlosen Plan zurückgekehrt.';
$string['license_expired_title']        = 'Premium-Lizenz abgelaufen';
$string['license_expires']           = 'Läuft ab am';
$string['license_expiring_desc']        = 'Ihre Premium-Lizenz läuft in {$a->days} Tagen ab. Erneuern Sie jetzt, um Unterbrechungen zu vermeiden.';
$string['license_expiring_title']       = 'Lizenz läuft bald ab';
$string['license_features']          = 'Enthaltene Funktionen';
$string['license_get_premium']       = 'SmartSMTP Premium erwerben';
$string['license_how_works_desc']    = 'Die Lizenz wird lokal mit RSA-Kryptografie überprüft. Keine Internetverbindung erforderlich. Der Schlüssel ist an die Domain Ihrer Moodle-Website gebunden.';
$string['license_how_works_title']   = 'So funktioniert die Lizenz:';
$string['license_invalid_key']       = 'Der Lizenzschlüssel ist ungültig oder entspricht nicht dieser Domain.';
$string['license_key']           = 'Premium-Lizenzschlüssel';
$string['license_key_desc']      = 'Geben Sie Ihren Lizenzschlüssel ein, um Premium-Funktionen freizuschalten.';
$string['license_key_placeholder']   = 'Fügen Sie hier Ihren Lizenzschlüssel ein...';
$string['license_management']        = 'Premium-Lizenz';
$string['license_premium_desc']      = 'Alle erweiterten Funktionen für $79 USD/Website/Jahr freischalten.';
$string['license_price']             = '$79 USD / Website / Jahr';
$string['license_renew']                = 'Lizenz erneuern';
$string['license_status_active']     = 'Lizenz aktiv';
$string['license_status_free']       = 'Kostenloser Plan';
$string['license_status_invalid']    = 'Ungültiger Schlüssel';
$string['log_retention_days']    = 'Protokollaufbewahrung (Tage)';
$string['log_retention_days_desc'] = 'Protokolle älter als diese Anzahl von Tagen werden automatisch gelöscht. Standard: 90.';
$string['manage_accounts']       = 'SMTP-Konten verwalten';
$string['manage_rules']          = 'Benachrichtigungsregeln';
$string['max_accounts_reached']  = 'Sie haben das Kontolimit für die kostenlose Version erreicht.';
$string['max_rules_reached']         = 'Regellimit im kostenlosen Plan erreicht.';
$string['max_rules_reached_detail']  = 'Der kostenlose Plan erlaubt maximal 2 Regeln.';
$string['need_account_for_rules'] = 'Sie benötigen mindestens ein aktiviertes SMTP-Konto bevor Sie Regeln hinzufügen.';
$string['no_accounts_yet']       = 'Keine SMTP-Konten konfiguriert. Fügen Sie Ihr erstes Konto hinzu.';
$string['no_logs_yet']           = 'Noch keine Versandprotokolle.';
$string['no_rules_yet']          = 'Keine Regeln konfiguriert. Alle E-Mails verwenden das Standardkonto.';
$string['non_interceptable_desc']    = 'Passwort-Wiederherstellungs- und Registrierungs-E-Mails verwenden immer das Standardpostfach und können nicht durch Regeln umgeleitet werden.';
$string['non_interceptable_title']   = 'Hinweis:';
$string['noreply_email']         = 'Noreply-E-Mail';
$string['noreply_email_help']    = 'E-Mail-Adresse, die als Absender in Systemnachrichten erscheint. Wenn leer, wird der SMTP-Benutzername verwendet. Beispiel: noreply@ihreuniversitaet.de';
$string['noreply_name']          = 'Absendername';
$string['noreply_name_help']     = 'Sichtbarer Name im "Von:"-Feld der E-Mails. Beispiel: Universität XYZ';
$string['noreply_note']          = 'Diese Werte werden angewendet wenn dieses Postfach das Standardpostfach ist. Betrifft alle System-E-Mails einschließlich Passwortwiederherstellung.';
$string['noreply_settings']      = 'Absenderkonfiguration (Noreply)';
$string['notes']                 = 'Notizen';
$string['password_leave_blank']  = 'Lassen Sie das Passwortfeld leer, wenn Sie es nicht ändern möchten.';
$string['pluginname']            = 'SmartSMTP Manager';

$string['premium_badge']             = 'Premium';
$string['premium_only_short']        = 'premium';
$string['premium_required']      = 'Diese Funktion erfordert eine Premium-Lizenz.';
$string['premium_url']           = 'https://raxelion.com/smartsmtp-premium';
$string['priority_help']         = 'Höhere Zahl = höhere Priorität. Standard: 0.';
$string['privacy:metadata']      = 'SmartSMTP Manager speichert keine personenbezogenen Daten direkt. Es speichert SMTP-Serverdaten und Versandprotokolle zu administrativen Zwecken.';
$string['privacy:metadata:smartsmtp_logs']           = 'SmartSMTP speichert E-Mail-Versandprotokolle zu administrativen Zwecken.';
$string['privacy:metadata:smartsmtp_logs:recipient'] = 'Die E-Mail-Adresse des Empfängers.';
$string['privacy:metadata:smartsmtp_logs:status']    = 'Ob die E-Mail erfolgreich gesendet wurde oder fehlgeschlagen ist.';
$string['privacy:metadata:smartsmtp_logs:subject']   = 'Der Betreff der gesendeten E-Mail.';
$string['privacy:metadata:smartsmtp_logs:timesent']  = 'Der Zeitpunkt, zu dem die E-Mail gesendet wurde.';
$string['recipient']             = 'Empfänger';
$string['rule_account']          = 'SMTP-Konto';
$string['rule_added']            = 'Regel erfolgreich hinzugefügt';
$string['rule_comp_analytics']       = 'Analysen';
$string['rule_comp_assign']          = 'Aufgaben';
$string['rule_comp_badges']          = 'Abzeichen';
$string['rule_comp_calendar']        = 'Kalender';
$string['rule_comp_chat']            = 'Chat';
$string['rule_comp_data']            = 'Datenbank';
$string['rule_comp_enrol_manual']    = 'Manuelle Einschreibung';
$string['rule_comp_enrol_self']      = 'Selbsteinschreibung';
$string['rule_comp_feedback']        = 'Feedback';
$string['rule_comp_forum']           = 'Foren';
$string['rule_comp_lesson']          = 'Lektion';
$string['rule_comp_message']         = 'Interne Nachrichten';
$string['rule_comp_monitor']         = 'Ereignismonitor';
$string['rule_comp_quiz']            = 'Tests';
$string['rule_comp_workshop']        = 'Workshop';
$string['rule_component']            = 'Komponente';
$string['rule_component_any']        = 'Beliebige Benachrichtigung (Fallback — exkl. Passwörter und Registrierung)';
$string['rule_component_help']       = 'Wählen Sie das Moodle-Modul aus, dessen E-Mails Sie über ein bestimmtes Postfach weiterleiten möchten. "Beliebige Benachrichtigung" gilt für alle E-Mails ohne spezifischere Regel.';
$string['rule_deleted']          = 'Regel erfolgreich gelöscht';
$string['rule_name_field']           = 'Technischer Benachrichtigungsname (optional)';
$string['rule_name_help']            = 'Erweiterter technischer Filter. LEER lassen um die Regel auf die gesamte Komponente anzuwenden.';
$string['rule_name_help_free']       = 'Verfügbar in Premium. Ermöglicht Filter nach genauen Benachrichtigungstypen.';
$string['rule_name_placeholder']     = 'z.B.: posts, due_date, assign_notification';
$string['rule_notification_type'] = 'Benachrichtigungstyp';
$string['rule_priority']         = 'Priorität';
$string['rule_roundrobin']           = 'Round-Robin';
$string['rule_roundrobin_help']      = 'Rotiert zwischen mehreren Postfächern mit derselben Regel. Verteilt die Last automatisch.';
$string['rule_roundrobin_help_free'] = 'Verfügbar in Premium. Verteilt E-Mails automatisch auf mehrere Postfächer.';
$string['rules_count_free']          = '{$a->current} von {$a->max} Regeln (Free-Plan)';
$string['rules_count_premium']       = '{$a} Regeln konfiguriert';
$string['rules_priority_example'] = 'Prioritätsbeispiel:
<ul>
<li><strong>Priorität 3</strong> — mod_assign → Gmail</li>
<li><strong>Priorität 2</strong> — mod_forum → Yahoo</li>
<li><strong>Priorität 1</strong> — Beliebige Benachrichtigung → Gmail (Fallback)</li>
</ul>
Wenn eine mod_assign-E-Mail eingeht, wird die Regel mit der höchsten übereinstimmenden Priorität verwendet.';
$string['security_none']         = 'Keine';
$string['sending_limits']        = 'Versandlimits';
$string['set_as_default']        = 'Als Standardkonto festlegen';
$string['set_as_default_help']   = 'Das Standard-Postfach wird verwendet für:
<ul>
<li>E-Mails zur Passwortwiederherstellung</li>
<li>E-Mails zur Registrierung neuer Benutzer</li>
<li>Alle E-Mails, die keiner Weiterleitungsregel entsprechen</li>
</ul>
Es kann jeweils nur ein Postfach als Standard festgelegt werden.';
$string['smartsmtp:manageaccounts'] = 'SmartSMTP-Konten verwalten';
$string['smartsmtp:viewlogs']       = 'SmartSMTP-Versandprotokolle anzeigen';
$string['smtp_auth']             = 'Authentifizierung';
$string['smtp_host']             = 'SMTP-Server';
$string['smtp_host_help']        = 'Adresse des SMTP-Servers. Beispiele: smtp.gmail.com, smtp.office365.com';
$string['smtp_password']         = 'Passwort';
$string['smtp_password_change']  = 'Neues Passwort (leer lassen um beizubehalten)';
$string['smtp_port']             = 'Port';
$string['smtp_port_help']        = 'Verbindungsport für den SMTP-Server. Häufige Ports:
<ul>
<li><strong>587</strong> — TLS (empfohlen für Gmail, Outlook, Yahoo)</li>
<li><strong>465</strong> — SSL</li>
<li><strong>25</strong> — Keine Verschlüsselung (nicht empfohlen)</li>
</ul>';
$string['smtp_security']         = 'Sicherheit';
$string['smtp_security_help']    = 'Verschlüsselungstyp für die SMTP-Verbindung:
<ul>
<li><strong>TLS</strong> — Empfohlen. Startet unverschlüsselt und wird dann verschlüsselt (Port 587)</li>
<li><strong>SSL</strong> — Von Anfang an verschlüsselt (Port 465)</li>
<li><strong>Keine</strong> — Keine Verschlüsselung. Nur für interne Testserver</li>
</ul>';
$string['smtp_settings']         = 'SMTP-Server';

$string['smtp_username']         = 'Benutzername';

$string['smtp_username_help']    = 'SMTP-Authentifizierungsbenutzername. Normalerweise Ihre vollständige E-Mail-Adresse.
<br>Beispiele: <code>mail@gmail.com</code>, <code>mail@ihredomain.edu</code>
<br><strong>Gmail:</strong> Verwenden Sie ein App-Passwort, nicht Ihr reguläres Passwort.';
$string['status']                = 'Status';
$string['status_failed']         = 'Fehlgeschlagen';
$string['status_fallback']       = 'Fallback verwendet';
$string['status_sent']           = 'Gesendet';
$string['subject']               = 'Betreff';
$string['task_cleanup_logs']     = 'SmartSMTP - Alte Protokolle bereinigen';
$string['task_reset_counters']   = 'SmartSMTP - Tägliche Zähler zurücksetzen';
$string['task_send_test']        = 'SmartSMTP - Test-E-Mail senden';
$string['test_connection']       = 'Verbindung testen';

$string['test_email_body']       = 'Dies ist eine Test-E-Mail vom SmartSMTP-Konto: {$a}';
$string['test_email_subject']    = 'SmartSMTP - Verbindungstest';
$string['test_queued']           = 'Test-E-Mail gesendet. Überprüfen Sie Ihren Posteingang in einigen Sekunden.';

$string['upgrade_to_premium']        = 'Premium erwerben';
