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
 * Italian language strings.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['account']               = 'Account';
$string['account_basic']         = 'Identificazione account';
$string['account_created']       = 'Account creato con successo';
$string['account_deleted']       = 'Account eliminato con successo';
$string['account_name']          = 'Nome account';
$string['account_notes']         = 'Note interne';
$string['account_updated']       = 'Account aggiornato con successo';
$string['add_account']           = 'Aggiungi account SMTP';
$string['add_rule']              = 'Aggiungi regola';
$string['all_accounts']          = 'Tutti gli account';
$string['all_statuses']          = 'Tutti gli stati';
$string['confirm_delete']        = 'Sei sicuro di voler eliminare questo account?';
$string['current_rules']             = 'Regole attuali';
$string['daily_limit']           = 'Limite invii giornalieri';
$string['daily_limit_help']      = 'Numero massimo di email al giorno. Usa 0 per illimitato (solo premium).';
$string['debug_mode']            = 'Modalità debug';
$string['debug_mode_desc']       = 'Registra l\'attività dettagliata di SmartSMTP nel debug di Moodle. Disattivare in produzione.';
$string['default']               = 'Predefinito';
$string['disabled']              = 'Disabilitato';
$string['docs_link']             = 'Documentazione completa su raxelion.com';
$string['docs_url']              = 'https://raxelion.com/smartsmtp/docs';
$string['edit_account']          = 'Modifica account SMTP';
$string['edit_blocked_reduce_accounts'] = 'La tua licenza premium è scaduta. Per modificare le caselle, riducile a {$a} o meno eliminando quelle in eccesso.';
$string['email_logs']            = 'Registro invii email';
$string['emails_today']          = 'email oggi';
$string['enabled']               = 'Abilitato';
$string['error']                 = 'Errore';
$string['error_all_full']        = 'Tutti gli account SMTP hanno raggiunto il limite giornaliero.';
$string['error_no_account']      = 'Nessun account SMTP disponibile. Configura almeno un account.';
$string['feature_name_granularity']    = 'Granularità per nome notifica';
$string['feature_roundrobin']          = 'Round-robin tra caselle';
$string['feature_unlimited_mailboxes'] = 'Caselle SMTP illimitate';
$string['feature_unlimited_rules']     = 'Regole di instradamento illimitate';
$string['free_banner_desc']            = 'Versione gratuita: {$a->current} di {$a->max} account utilizzati.';
$string['general_settings']      = 'Impostazioni generali';
$string['invalid_limit']         = 'Il limite giornaliero deve essere 0 o maggiore.';
$string['invalid_port']          = 'La porta deve essere un numero tra 1 e 65535.';
$string['license_activate']          = 'Attiva';
$string['license_activated']         = 'Licenza attivata con successo.';
$string['license_buy_now']           = 'Acquista ora';
$string['license_clear']             = 'Rimuovi licenza';
$string['license_clear_confirm']     = 'Tornerai al piano gratuito. Continuare?';
$string['license_cleared']           = 'Licenza rimossa. Sei ora nel piano gratuito.';
$string['license_days_left']            = '{$a} giorni rimanenti';
$string['license_domain']            = 'Dominio licenziato';
$string['license_enter_key']         = 'Attiva licenza';
$string['license_expired_accounts_desc'] = 'La tua licenza è scaduta e hai {$a->count} caselle configurate (limite: {$a->max}). La modifica è bloccata finché non riduci a {$a->max} o meno, o rinnovi la licenza.';
$string['license_expired_desc']         = 'La tua licenza premium è scaduta. Il plugin è tornato al piano gratuito.';
$string['license_expired_title']        = 'Licenza premium scaduta';
$string['license_expires']           = 'Scade il';
$string['license_expiring_desc']        = 'La tua licenza premium scade tra {$a->days} giorni. Rinnova ora per evitare interruzioni.';
$string['license_expiring_title']       = 'Licenza in scadenza';
$string['license_features']          = 'Funzioni incluse';
$string['license_get_premium']       = 'Ottieni SmartSMTP Premium';
$string['license_how_works_desc']    = 'La licenza viene verificata localmente usando firma crittografica RSA. Non richiede connessione internet. La chiave è legata al dominio del tuo sito Moodle.';
$string['license_how_works_title']   = 'Come funziona la licenza:';
$string['license_invalid_key']       = 'La chiave di licenza non è valida o non corrisponde a questo dominio.';
$string['license_key']           = 'Chiave di licenza premium';
$string['license_key_desc']      = 'Inserisci la tua chiave di licenza per sbloccare le funzioni premium.';
$string['license_key_placeholder']   = 'Incolla qui la tua chiave di licenza...';
$string['license_management']        = 'Licenza premium';
$string['license_premium_desc']      = 'Sblocca tutte le funzioni avanzate per $79 USD/sito/anno.';
$string['license_price']             = '$79 USD / sito / anno';
$string['license_renew']                = 'Rinnova licenza';
$string['license_status_active']     = 'Licenza attiva';
$string['license_status_free']       = 'Piano gratuito';
$string['license_status_invalid']    = 'Chiave non valida';
$string['log_retention_days']    = 'Conservazione log (giorni)';
$string['log_retention_days_desc'] = 'I log più vecchi di questo numero di giorni verranno eliminati automaticamente. Predefinito: 90.';
$string['manage_accounts']       = 'Gestisci account SMTP';
$string['manage_rules']          = 'Regole di notifica';
$string['max_accounts_reached']  = 'Hai raggiunto il limite di account per la versione gratuita.';
$string['max_rules_reached']         = 'Limite regole raggiunto nel piano gratuito.';
$string['max_rules_reached_detail']  = 'Il piano gratuito permette al massimo 2 regole.';
$string['need_account_for_rules'] = 'È necessario almeno un account SMTP abilitato prima di aggiungere regole.';
$string['no_accounts_yet']       = 'Nessun account SMTP configurato. Aggiungi il tuo primo account.';
$string['no_logs_yet']           = 'Nessun registro di invio ancora.';
$string['no_rules_yet']          = 'Nessuna regola configurata. Tutte le email useranno l\'account predefinito.';
$string['non_interceptable_desc']    = 'Le email di recupero password e registrazione usano sempre la casella predefinita e non possono essere reindirizzate dalle regole.';
$string['non_interceptable_title']   = 'Nota:';
$string['noreply_email']         = 'Email noreply';
$string['noreply_email_help']    = 'Indirizzo email che appare come mittente nei messaggi di sistema. Se vuoto, usa il nome utente SMTP. Esempio: noreply@tuauniversita.it';
$string['noreply_name']          = 'Nome mittente';
$string['noreply_name_help']     = 'Nome visibile nel campo "Da:" delle email. Esempio: Università XYZ';
$string['noreply_note']          = 'Questi valori vengono applicati quando questa casella è quella predefinita. Influisce su tutte le email di sistema incluso il recupero password.';
$string['noreply_settings']      = 'Configurazione mittente (noreply)';
$string['notes']                 = 'Note';
$string['password_leave_blank']  = 'Lascia il campo password vuoto se non vuoi modificarla.';
$string['pluginname']            = 'SmartSMTP Manager';

$string['premium_badge']             = 'Premium';
$string['premium_only_short']        = 'premium';
$string['premium_required']      = 'Questa funzione richiede una licenza premium.';
$string['premium_url']           = 'https://raxelion.com/smartsmtp-premium';
$string['priority_help']         = 'Numero maggiore = priorità maggiore. Predefinito: 0.';
$string['privacy:metadata']      = 'SmartSMTP Manager non memorizza dati personali direttamente. Memorizza credenziali server SMTP e registri di invio email per scopi amministrativi.';
$string['privacy:metadata:smartsmtp_logs']           = 'SmartSMTP memorizza registri di invio email per scopi amministrativi.';
$string['privacy:metadata:smartsmtp_logs:recipient'] = 'L\'indirizzo email del destinatario.';
$string['privacy:metadata:smartsmtp_logs:status']    = 'Se l\'email è stata inviata con successo o ha avuto un errore.';
$string['privacy:metadata:smartsmtp_logs:subject']   = 'L\'oggetto dell\'email inviata.';
$string['privacy:metadata:smartsmtp_logs:timesent']  = 'L\'ora in cui l\'email è stata inviata.';
$string['recipient']             = 'Destinatario';
$string['rule_account']          = 'Account SMTP';
$string['rule_added']            = 'Regola aggiunta con successo';
$string['rule_comp_analytics']       = 'Analisi';
$string['rule_comp_assign']          = 'Compiti';
$string['rule_comp_badges']          = 'Badge';
$string['rule_comp_calendar']        = 'Calendario';
$string['rule_comp_chat']            = 'Chat';
$string['rule_comp_data']            = 'Database';
$string['rule_comp_enrol_manual']    = 'Iscrizione manuale';
$string['rule_comp_enrol_self']      = 'Iscrizione autonoma';
$string['rule_comp_feedback']        = 'Feedback';
$string['rule_comp_forum']           = 'Forum';
$string['rule_comp_lesson']          = 'Lezione';
$string['rule_comp_message']         = 'Messaggi interni';
$string['rule_comp_monitor']         = 'Monitor eventi';
$string['rule_comp_quiz']            = 'Quiz';
$string['rule_comp_workshop']        = 'Workshop';
$string['rule_component']            = 'Componente';
$string['rule_component_any']        = 'Qualsiasi notifica (fallback — esclude password e registrazioni)';
$string['rule_component_help']       = 'Seleziona il modulo Moodle le cui email vuoi instradare tramite una casella specifica. "Qualsiasi notifica" si applica a tutte le email senza una regola più specifica.';
$string['rule_deleted']          = 'Regola eliminata con successo';
$string['rule_name_field']           = 'Nome tecnico notifica (opzionale)';
$string['rule_name_help']            = 'Filtro tecnico avanzato. Lascia VUOTO per applicare la regola all\'intero componente.';
$string['rule_name_help_free']       = 'Disponibile in Premium. Permette di filtrare per tipo esatto di notifica nel componente.';
$string['rule_name_placeholder']     = 'es: posts, due_date, assign_notification';
$string['rule_notification_type'] = 'Tipo di notifica';
$string['rule_priority']         = 'Priorità';
$string['rule_roundrobin']           = 'Round-robin';
$string['rule_roundrobin_help']      = 'Ruota tra più caselle con la stessa regola. Distribuisce il carico automaticamente.';
$string['rule_roundrobin_help_free'] = 'Disponibile in Premium. Distribuisce le email tra più caselle automaticamente.';
$string['rules_count_free']          = '{$a->current} di {$a->max} regole (piano Free)';
$string['rules_count_premium']       = '{$a} regole configurate';
$string['rules_priority_example'] = 'Esempio di priorità:
<ul>
<li><strong>Priorità 3</strong> — mod_assign → Gmail (valutata per prima)</li>
<li><strong>Priorità 2</strong> — mod_forum → Yahoo</li>
<li><strong>Priorità 1</strong> — Qualsiasi notifica → Gmail (fallback)</li>
</ul>
Quando arriva un\'email di mod_assign, viene utilizzata la regola con la priorità corrispondente più alta.';
$string['security_none']         = 'Nessuna';
$string['sending_limits']        = 'Limiti di invio';
$string['set_as_default']        = 'Imposta come account predefinito';
$string['set_as_default_help']   = 'La casella predefinita viene utilizzata per:
<ul>
<li>Email di recupero password</li>
<li>Email di registrazione nuovi utenti</li>
<li>Qualsiasi email che non corrisponde a nessuna regola di instradamento</li>
</ul>
Solo una casella può essere impostata come predefinita alla volta.';
$string['smartsmtp:manageaccounts'] = 'Gestisci account SmartSMTP';
$string['smartsmtp:viewlogs']       = 'Visualizza registri invio SmartSMTP';
$string['smtp_auth']             = 'Autenticazione';
$string['smtp_host']             = 'Server SMTP';
$string['smtp_host_help']        = 'Indirizzo del server SMTP. Esempi: smtp.gmail.com, smtp.office365.com';
$string['smtp_password']         = 'Password';
$string['smtp_password_change']  = 'Nuova password (lascia vuoto per non modificare)';
$string['smtp_port']             = 'Porta';
$string['smtp_port_help']        = 'Porta di connessione al server SMTP. Porte comuni:
<ul>
<li><strong>587</strong> — TLS (consigliato per Gmail, Outlook, Yahoo)</li>
<li><strong>465</strong> — SSL</li>
<li><strong>25</strong> — Nessuna crittografia (non consigliato)</li>
</ul>';
$string['smtp_security']         = 'Sicurezza';
$string['smtp_security_help']    = "Tipo di crittografia per la connessione SMTP:
<ul>
<li><strong>TLS</strong> — Consigliato. Inizia senza crittografia poi la attiva (porta 587)</li>
<li><strong>SSL</strong> — Crittografato dall'inizio (porta 465)</li>
<li><strong>Nessuna</strong> — Solo per server di test interni</li>
</ul>";
$string['smtp_settings']         = 'Server SMTP';

$string['smtp_username']         = 'Nome utente';

$string['smtp_username_help']    = "Nome utente per l'autenticazione SMTP. Di solito è il tuo indirizzo email completo.
<br>Esempi: <code>mail@gmail.com</code>, <code>mail@tuodominio.edu</code>
<br><strong>Gmail:</strong> Usa una password per le app, non la tua password normale.";
$string['status']                = 'Stato';
$string['status_failed']         = 'Fallito';
$string['status_fallback']       = 'Fallback utilizzato';
$string['status_sent']           = 'Inviato';
$string['subject']               = 'Oggetto';
$string['task_cleanup_logs']     = 'SmartSMTP - Pulisci log vecchi';
$string['task_reset_counters']   = 'SmartSMTP - Reimposta contatori giornalieri';
$string['task_send_test']        = 'SmartSMTP - Invia email di test';
$string['test_connection']       = 'Testa connessione';

$string['test_email_body']       = 'Questa è un\'email di test inviata dall\'account SmartSMTP: {$a}';
$string['test_email_subject']    = 'SmartSMTP - Test di connessione';
$string['test_queued']           = 'Email di test inviata. Controlla la tua casella tra qualche secondo.';

$string['upgrade_to_premium']        = 'Passa a Premium';
