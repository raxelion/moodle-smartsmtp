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
 * English language strings.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['account']               = 'Account';
$string['account_basic']         = 'Account identification';
$string['account_created']       = 'Account created successfully';
$string['account_deleted']       = 'Account deleted successfully';
$string['account_name']          = 'Account name';
$string['account_notes']         = 'Internal notes';
$string['account_updated']       = 'Account updated successfully';
$string['add_account']           = 'Add SMTP account';
$string['add_rule']              = 'Add rule';
$string['all_accounts']         = 'All accounts';
$string['all_statuses']         = 'All statuses';
$string['confirm_delete']        = 'Are you sure you want to delete this account?';
$string['current_rules']             = 'Current rules';
$string['daily_limit']           = 'Daily sending limit';
$string['daily_limit_help']      = 'Maximum number of emails per day. Set to 0 for unlimited (premium only).';
$string['debug_mode']            = 'Debug mode';
$string['debug_mode_desc']       = 'Log detailed SmartSMTP activity to Moodle debug output. Disable in production.';
$string['default']               = 'Default';
$string['disabled']              = 'Disabled';
$string['docs_link']             = 'Full documentation at raxelion.com';
$string['docs_url']              = 'https://raxelion.com/smartsmtp/docs';
$string['edit_account']          = 'Edit SMTP account';
$string['edit_blocked_reduce_accounts'] = 'Your premium license has expired. To edit accounts, reduce your mailboxes to {$a} or fewer by deleting the excess ones.';
$string['email_logs']            = 'Email sending logs';
$string['emails_today']          = 'emails today';
$string['enabled']               = 'Enabled';
$string['error']                 = 'Error';
$string['error_all_full']        = 'All SMTP accounts have reached their daily sending limit.';
$string['error_no_account']      = 'No SMTP account available. Please configure at least one account.';
$string['feature_name_granularity']    = 'Notification name granularity';
$string['feature_roundrobin']          = 'Round-robin between mailboxes';
$string['feature_unlimited_mailboxes'] = 'Unlimited SMTP mailboxes';
$string['feature_unlimited_rules']     = 'Unlimited routing rules';
$string['free_banner_desc']            = 'Free plan: {$a->current} of {$a->max} accounts used.';
$string['general_settings']      = 'General settings';
$string['invalid_limit']         = 'Daily limit must be 0 or greater.';
$string['invalid_port']          = 'Port must be a number between 1 and 65535.';
$string['license_activate']         = 'Activate';
$string['license_activated']        = 'License activated successfully.';
$string['license_buy_now']          = 'Buy now';
$string['license_clear']            = 'Remove license';
$string['license_clear_confirm']    = 'You will return to the free plan. Continue?';
$string['license_cleared']          = 'License removed. You are now on the free plan.';
$string['license_days_left']            = '{$a} days remaining';
$string['license_domain']           = 'Licensed domain';
$string['license_enter_key']        = 'Activate license';
$string['license_expired_accounts_desc'] = 'Your license has expired and you have {$a->count} mailboxes configured (limit: {$a->max}). Editing is blocked until you reduce to {$a->max} or fewer, or renew your license.';
$string['license_expired_desc']         = 'Your premium license has expired. The plugin has reverted to the free plan.';
$string['license_expired_title']        = 'Premium license expired';
$string['license_expires']          = 'Expires on';
$string['license_expiring_desc']        = 'Your premium license expires in {$a->days} days. Renew now to avoid service interruption.';
$string['license_expiring_title']       = 'License expiring soon';
$string['license_features']         = 'Included features';
$string['license_get_premium']      = 'Get SmartSMTP Premium';
$string['license_how_works_desc']   = 'The license is verified locally using RSA cryptographic signatures. No internet connection required. The key is bound to your Moodle site domain.';
$string['license_how_works_title']  = 'How licensing works:';
$string['license_invalid_key']      = 'The license key is invalid or does not match this domain.';
$string['license_key']           = 'Premium license key';
$string['license_key_desc']      = 'Enter your license key to unlock premium features.';
$string['license_key_placeholder']  = 'Paste your license key here...';
$string['license_management']       = 'Premium license';
$string['license_premium_desc']     = 'Unlock all advanced features for $79 USD/site/year.';
$string['license_price']            = '$79 USD / site / year';
$string['license_renew']                = 'Renew license';
$string['license_status_active']    = 'License active';
$string['license_status_free']      = 'Free plan';
$string['license_status_invalid']   = 'Invalid key';
$string['log_retention_days']    = 'Log retention (days)';
$string['log_retention_days_desc'] = 'Logs older than this number of days will be automatically deleted. Default: 90.';
$string['manage_accounts']       = 'Manage SMTP accounts';
$string['manage_rules']          = 'Notification rules';
$string['max_accounts_reached']      = 'You have reached the account limit for the free version.';
$string['max_rules_reached']         = 'Rule limit reached on the free plan.';
$string['max_rules_reached_detail']  = 'The free plan allows a maximum of 2 rules.';
$string['need_account_for_rules']    = 'You need at least one enabled SMTP account before adding rules.';
$string['no_accounts_yet']       = 'No SMTP accounts configured yet. Add your first account.';
$string['no_logs_yet']          = 'No send records yet.';
$string['no_rules_yet']          = 'No rules configured. All emails will use the default account.';
$string['non_interceptable_desc']    = 'Password recovery and new user registration emails always use the default mailbox and cannot be redirected by rules. The "moodle" component rule has no effect on these emails.';
$string['non_interceptable_title']   = 'Note:';
$string['noreply_email']        = 'Noreply email';
$string['noreply_email_help']   = 'Email address used as sender for system messages. If empty, the SMTP username is used as fallback. Example: no-reply@youruniversity.edu';
$string['noreply_name']         = 'Sender name';
$string['noreply_name_help']    = 'Name shown in the "From:" field of emails. Example: University XYZ';
$string['noreply_note']         = 'These values are applied as global Moodle configuration when this mailbox is the default. Affects all system emails including password recovery.';
$string['noreply_settings']     = 'Sender (noreply) configuration';
$string['notes']                 = 'Notes';
$string['password_leave_blank']  = 'Leave the password field blank if you do not want to change it.';
$string['pluginname']            = 'SmartSMTP Manager';

$string['premium_badge']             = 'Premium';
$string['premium_only_short']        = 'premium';
$string['premium_required']      = 'Unlimited sending requires a premium license.';
$string['premium_url']           = 'https://raxelion.com/smartsmtp-premium';
$string['priority_help']             = 'Higher number = higher priority. Default: 0.';
$string['privacy:metadata']      = 'SmartSMTP Manager does not store personal data directly. It stores SMTP server credentials and email sending logs for administrative purposes.';
$string['privacy:metadata:smartsmtp_logs']           = 'SmartSMTP stores email sending logs for administrative purposes.';
$string['privacy:metadata:smartsmtp_logs:recipient'] = 'The email address of the recipient.';
$string['privacy:metadata:smartsmtp_logs:status']    = 'Whether the email was sent successfully or failed.';
$string['privacy:metadata:smartsmtp_logs:subject']   = 'The subject of the email sent.';
$string['privacy:metadata:smartsmtp_logs:timesent']  = 'The time the email was sent.';
$string['recipient']             = 'Recipient';
$string['rule_account']          = 'SMTP account';
$string['rule_added']            = 'Rule added successfully';
$string['rule_comp_analytics']       = 'Analytics';
$string['rule_comp_assign']          = 'Assignments';
$string['rule_comp_badges']          = 'Badges';
$string['rule_comp_calendar']        = 'Calendar';
$string['rule_comp_chat']            = 'Chat';
$string['rule_comp_data']            = 'Database';
$string['rule_comp_enrol_manual']    = 'Manual enrolment';
$string['rule_comp_enrol_self']      = 'Self enrolment';
$string['rule_comp_feedback']        = 'Feedback';
$string['rule_comp_forum']           = 'Forums';
$string['rule_comp_lesson']          = 'Lesson';
$string['rule_comp_message']         = 'Internal messages';
$string['rule_comp_monitor']         = 'Event monitor';
$string['rule_comp_quiz']            = 'Quizzes';
$string['rule_comp_workshop']        = 'Workshop';
$string['rule_component']            = 'Component';
$string['rule_component_any']        = 'Any notification (fallback — excludes passwords and registration)';
$string['rule_component_help']       = 'Select the Moodle module whose emails you want to route through a specific mailbox. If you select "Any notification", this rule applies to all emails that do not match a more specific rule.';
$string['rule_deleted']          = 'Rule deleted successfully';
$string['rule_name_field']           = 'Technical notification name (optional)';
$string['rule_name_help']            = 'Advanced technical filter. Leave EMPTY to apply the rule to ALL notifications from this component. Only use it to differentiate between specific notification types within the same component.';
$string['rule_name_help_free']       = 'Available in Premium.';
$string['rule_name_placeholder']     = 'e.g. posts, due_date, assign_notification';
$string['rule_notification_type'] = 'Notification type';
$string['rule_priority']         = 'Priority';
$string['rule_roundrobin']           = 'Round-robin';
$string['rule_roundrobin_help']      = 'Rotates between multiple mailboxes sharing the same rule.';
$string['rule_roundrobin_help_free'] = 'Available in Premium.';
$string['rules_count_free']          = '{$a->current} of {$a->max} rules (Free plan)';
$string['rules_count_premium']       = '{$a} rules configured';
$string['rules_priority_example'] = 'Priority example:
<ul>
<li><strong>Priority 3</strong> — mod_assign → Gmail (evaluated first)</li>
<li><strong>Priority 2</strong> — mod_forum → Yahoo</li>
<li><strong>Priority 1</strong> — Any notification → Gmail (fallback)</li>
</ul>
When a mod_assign email arrives, the rule with the highest matching priority is used.';
$string['security_none']         = 'None';
$string['sending_limits']        = 'Sending limits';
$string['set_as_default']        = 'Set as default account';
$string['set_as_default_help']   = 'The default mailbox is used for:
<ul>
<li>Password recovery emails</li>
<li>New user registration emails</li>
<li>Any email that does not match any routing rule</li>
</ul>
Only one mailbox can be default at a time.';
$string['smartsmtp:manageaccounts'] = 'Manage SmartSMTP accounts';
$string['smartsmtp:viewlogs']       = 'View SmartSMTP sending logs';
$string['smtp_auth']             = 'Authentication';
$string['smtp_host']             = 'SMTP host';
$string['smtp_host_help']        = 'The address of your SMTP server. Examples: smtp.gmail.com, smtp.office365.com';
$string['smtp_password']         = 'Password';
$string['smtp_password_change']  = 'New password (leave blank to keep current)';
$string['smtp_port']             = 'Port';
$string['smtp_port_help']        = 'Connection port for the SMTP server. Common ports:
<ul>
<li><strong>587</strong> — TLS (recommended for Gmail, Outlook, Yahoo)</li>
<li><strong>465</strong> — SSL</li>
<li><strong>25</strong> — No encryption (not recommended)</li>
</ul>';
$string['smtp_security']         = 'Security';
$string['smtp_security_help']    = 'Encryption type for the SMTP connection:
<ul>
<li><strong>TLS</strong> — Recommended. Starts unencrypted then upgrades (port 587)</li>
<li><strong>SSL</strong> — Encrypted from the start (port 465)</li>
<li><strong>None</strong> — No encryption. Only for internal test servers</li>
</ul>';
$string['smtp_settings']         = 'SMTP server';

$string['smtp_username']         = 'Username';

$string['smtp_username_help']    = 'SMTP authentication username. Usually your full email address.
<br>Examples: <code>mail@gmail.com</code>, <code>mail@yourdomain.edu</code>
<br><strong>Gmail:</strong> Use an App Password, not your regular password.';
$string['status']                = 'Status';
$string['status_failed']         = 'Failed';
$string['status_fallback']       = 'Fallback used';
$string['status_sent']           = 'Sent';
$string['subject']               = 'Subject';
$string['task_cleanup_logs']     = 'SmartSMTP - Clean old logs';
$string['task_reset_counters']   = 'SmartSMTP - Reset daily counters';
$string['task_send_test']        = 'SmartSMTP - Send test email';
$string['test_connection']       = 'Test connection';

$string['test_email_body']       = 'This is a test email sent from SmartSMTP account: {$a}';
$string['test_email_subject']    = 'SmartSMTP - Connection test';
$string['test_queued']           = 'Test email queued. Check your inbox in a few seconds.';

$string['upgrade_to_premium']        = 'Get Premium';
