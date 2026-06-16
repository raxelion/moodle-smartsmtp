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
 * Mexican Spanish language strings.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['account']               = 'Cuenta';
$string['account_basic']         = 'Identificación de la cuenta';
$string['account_created']       = 'Cuenta creada correctamente';
$string['account_deleted']       = 'Cuenta eliminada correctamente';
$string['account_name']          = 'Nombre de la cuenta';
$string['account_notes']         = 'Notas internas';
$string['account_updated']       = 'Cuenta actualizada correctamente';
$string['add_account']           = 'Agregar cuenta SMTP';
$string['add_rule']              = 'Agregar regla';
$string['all_accounts']          = 'Todas las cuentas';
$string['all_statuses']          = 'Todos los estados';
$string['confirm_delete']        = '¿Está seguro de eliminar esta cuenta?';
$string['current_rules']             = 'Reglas actuales';
$string['daily_limit']           = 'Límite de envíos diarios';
$string['daily_limit_help']      = 'Máximo de correos por día. Usa 0 para ilimitado (solo premium).';
$string['debug_mode']            = 'Modo de depuración';
$string['debug_mode_desc']       = 'Registrar actividad detallada de SmartSMTP en el debug de Moodle. Desactivar en producción.';
$string['default']               = 'Predeterminada';
$string['disabled']              = 'Deshabilitada';
$string['docs_link']             = 'Documentación completa en raxelion.com';
$string['docs_url']              = 'https://raxelion.com/smartsmtp/docs';
$string['edit_account']          = 'Editar cuenta SMTP';
$string['edit_blocked_reduce_accounts'] = 'Tu licencia premium ha vencido. Para editar buzones, reduce tu cantidad a {$a} o menos eliminando los excedentes.';
$string['email_logs']            = 'Registros de envío de correo';
$string['emails_today']          = 'correos hoy';
$string['enabled']               = 'Habilitada';
$string['error']                 = 'Error';
$string['error_all_full']        = 'Todas las cuentas SMTP han alcanzado su límite diario de envío.';
$string['error_no_account']      = 'No hay cuenta SMTP disponible. Configura al menos una cuenta.';
$string['feature_name_granularity']    = 'Granularidad por nombre de notificación';
$string['feature_roundrobin']          = 'Round-robin entre buzones';
$string['feature_unlimited_mailboxes'] = 'Buzones SMTP ilimitados';
$string['feature_unlimited_rules']     = 'Reglas de enrutamiento ilimitadas';
$string['free_banner_desc']            = 'Versión gratuita: {$a->current} de {$a->max} cuentas usadas.';
$string['general_settings']      = 'Configuración general';
$string['invalid_limit']         = 'El límite diario debe ser 0 o mayor.';
$string['invalid_port']          = 'El puerto debe ser un número entre 1 y 65535.';
$string['license_activate']          = 'Activar';
$string['license_activated']         = 'Licencia activada correctamente.';
$string['license_buy_now']           = 'Comprar ahora';
$string['license_clear']             = 'Eliminar licencia';
$string['license_clear_confirm']     = '¿Volverás al plan gratuito. Continuar?';
$string['license_cleared']           = 'Licencia eliminada. Volviste al plan gratuito.';
$string['license_days_left']            = '{$a} días restantes';
$string['license_domain']            = 'Dominio licenciado';
$string['license_enter_key']         = 'Activar licencia';
$string['license_expired_accounts_desc'] = 'Tu licencia ha vencido y tienes {$a->count} buzones configurados (límite: {$a->max}). La edición está bloqueada hasta que reduzcas a {$a->max} o menos, o renueves tu licencia.';
$string['license_expired_desc']         = 'Tu licencia premium ha vencido. El plugin ha regresado al plan gratuito.';
$string['license_expired_title']        = 'Licencia premium vencida';
$string['license_expires']           = 'Vence el';
$string['license_expiring_desc']        = 'Tu licencia premium vence en {$a->days} días. Renueva ahora para evitar interrupciones.';
$string['license_expiring_title']       = 'Licencia por vencer';
$string['license_features']          = 'Funciones incluidas';
$string['license_get_premium']       = 'Obtener SmartSMTP Premium';
$string['license_how_works_desc']    = 'La licencia se verifica localmente usando firma criptográfica RSA. No requiere conexión a internet. La clave queda ligada al dominio de tu sitio Moodle.';
$string['license_how_works_title']   = 'Cómo funciona la licencia:';
$string['license_invalid_key']       = 'La clave de licencia no es válida o no corresponde a este dominio.';
$string['license_key']           = 'Clave de licencia premium';
$string['license_key_desc']      = 'Ingresa tu clave de licencia para desbloquear funciones premium.';
$string['license_key_placeholder']   = 'Pega aquí tu clave de licencia...';
$string['license_management']        = 'Licencia premium';
$string['license_premium_desc']      = 'Desbloquea todas las funciones avanzadas por $79 USD/sitio/año.';
$string['license_price']             = '$79 USD / sitio / año';
$string['license_renew']                = 'Renovar licencia';
$string['license_status_active']     = 'Licencia activa';
$string['license_status_free']       = 'Plan gratuito';
$string['license_status_invalid']    = 'Clave inválida';
$string['log_retention_days']    = 'Retención de logs (días)';
$string['log_retention_days_desc'] = 'Los logs más antiguos que este número de días se eliminarán automáticamente. Por defecto: 90.';
$string['manage_accounts']       = 'Administrar cuentas SMTP';
$string['manage_rules']          = 'Reglas de notificación';
$string['max_accounts_reached']  = 'Has alcanzado el límite de cuentas para la versión gratuita.';
$string['max_rules_reached']         = 'Límite de reglas alcanzado en el plan gratuito.';
$string['max_rules_reached_detail']  = 'El plan gratuito permite máximo 2 reglas.';
$string['need_account_for_rules'] = 'Necesitas al menos una cuenta SMTP habilitada antes de agregar reglas.';
$string['no_accounts_yet']       = 'No hay cuentas SMTP configuradas. Agrega tu primera cuenta.';
$string['no_logs_yet']           = 'No hay registros de envío aún.';
$string['no_rules_yet']          = 'Sin reglas configuradas. Todos los correos usarán la cuenta predeterminada.';
$string['non_interceptable_desc']    = 'Los correos de recuperación de contraseña y registro usan siempre el buzón predeterminado. Estos no pueden ser redirigidos por reglas.';
$string['non_interceptable_title']   = 'Nota:';
$string['noreply_email']         = 'Correo noreply';
$string['noreply_email_help']    = 'Correo que aparece como remitente. Si se deja en blanco, se usa el usuario SMTP del buzón. Ejemplo: no-responder@tuuniversidad.edu';
$string['noreply_name']          = 'Nombre del remitente';
$string['noreply_name_help']     = 'Nombre visible en el campo "De:" de los correos. Ejemplo: Universidad XYZ';
$string['noreply_note']          = 'Estos valores se aplican cuando este buzón es el predeterminado. Afecta correos del sistema incluyendo recuperación de contraseña.';
$string['noreply_settings']      = 'Configuración de remitente (noreply)';
$string['notes']                 = 'Notas';
$string['password_leave_blank']  = 'Deja el campo de contraseña en blanco si no deseas cambiarla.';
$string['pluginname']            = 'SmartSMTP Manager';

$string['premium_badge']             = 'Premium';
$string['premium_only_short']        = 'premium';
$string['premium_required']      = 'Esta función requiere una licencia premium.';
$string['premium_url']           = 'https://raxelion.com/smartsmtp-premium';
$string['priority_help']         = 'Número mayor = mayor prioridad. Por defecto: 0.';
$string['privacy:metadata']      = 'SmartSMTP Manager no almacena datos personales directamente. Almacena credenciales de servidor SMTP y registros de envío de correo (destinatario, asunto, estado) con fines administrativos.';
$string['privacy:metadata:smartsmtp_logs']           = 'SmartSMTP almacena registros de envío de correo con fines administrativos.';
$string['privacy:metadata:smartsmtp_logs:recipient'] = 'La dirección de correo del destinatario.';
$string['privacy:metadata:smartsmtp_logs:status']    = 'Si el correo se envió correctamente o falló.';
$string['privacy:metadata:smartsmtp_logs:subject']   = 'El asunto del correo enviado.';
$string['privacy:metadata:smartsmtp_logs:timesent']  = 'La hora en que se envió el correo.';
$string['recipient']             = 'Destinatario';
$string['rule_account']          = 'Cuenta SMTP';
$string['rule_added']            = 'Regla agregada correctamente';
$string['rule_comp_analytics']       = 'Analítica';
$string['rule_comp_assign']          = 'Tareas';
$string['rule_comp_badges']          = 'Insignias';
$string['rule_comp_calendar']        = 'Calendario';
$string['rule_comp_chat']            = 'Chat';
$string['rule_comp_data']            = 'Base de datos';
$string['rule_comp_enrol_manual']    = 'Matrícula manual';
$string['rule_comp_enrol_self']      = 'Matrícula voluntaria';
$string['rule_comp_feedback']        = 'Retroalimentación';
$string['rule_comp_forum']           = 'Foros';
$string['rule_comp_lesson']          = 'Lección';
$string['rule_comp_message']         = 'Mensajes internos';
$string['rule_comp_monitor']         = 'Monitor de eventos';
$string['rule_comp_quiz']            = 'Cuestionarios';
$string['rule_comp_workshop']        = 'Taller';
$string['rule_component']            = 'Componente';
$string['rule_component_any']        = 'Cualquier notificación (fallback — excluye contraseñas y registro)';
$string['rule_component_help']       = 'Selecciona el módulo de Moodle cuyos correos quieres enrutar por un buzón específico. Si seleccionas "Cualquier notificación", esta regla aplica a todos los correos que no tengan una regla más específica.';
$string['rule_deleted']          = 'Regla eliminada correctamente';
$string['rule_name_field']           = 'Nombre técnico de notificación (opcional)';
$string['rule_name_help']            = 'Filtro técnico avanzado. Déjalo VACÍO para aplicar la regla a TODO el componente.';
$string['rule_name_help_free']       = 'Disponible en Premium. Permite filtrar por tipo exacto de notificación dentro del componente.';
$string['rule_name_placeholder']     = 'ej: posts, due_date, assign_notification';
$string['rule_notification_type'] = 'Tipo de notificación';
$string['rule_priority']         = 'Prioridad';
$string['rule_roundrobin']           = 'Round-robin';
$string['rule_roundrobin_help']      = 'Rota entre varios buzones con la misma regla. Distribuye la carga automáticamente.';
$string['rule_roundrobin_help_free'] = 'Disponible en Premium. Distribuye correos entre varios buzones automáticamente.';
$string['rules_count_free']          = '{$a->current} de {$a->max} reglas (plan Free)';
$string['rules_count_premium']       = '{$a} reglas configuradas';
$string['rules_priority_example'] = 'Ejemplo de prioridades:
<ul>
<li><strong>Prioridad 3</strong> — mod_assign → Gmail (se evalúa primero)</li>
<li><strong>Prioridad 2</strong> — mod_forum → Yahoo</li>
<li><strong>Prioridad 1</strong> — Cualquier notificación → Gmail (fallback)</li>
</ul>
Cuando llega un correo de mod_assign, se usa la regla con mayor prioridad que coincida.';
$string['security_none']         = 'Ninguna';
$string['sending_limits']        = 'Límites de envío';
$string['set_as_default']        = 'Establecer como cuenta predeterminada';
$string['set_as_default_help']   = 'El buzón predeterminado se usa para:
<ul>
<li>Correos de recuperación de contraseña</li>
<li>Correos de registro de nuevos usuarios</li>
<li>Cualquier correo que no coincida con ninguna regla de enrutamiento</li>
</ul>
Solo puede haber un buzón predeterminado a la vez.';
$string['smartsmtp:manageaccounts'] = 'Administrar cuentas SmartSMTP';
$string['smartsmtp:viewlogs']       = 'Ver registros de envío SmartSMTP';
$string['smtp_auth']             = 'Autenticación';
$string['smtp_host']             = 'Servidor SMTP';
$string['smtp_host_help']        = 'Dirección del servidor SMTP. Ejemplos: smtp.gmail.com, smtp.office365.com';
$string['smtp_password']         = 'Contraseña';
$string['smtp_password_change']  = 'Nueva contraseña (dejar en blanco para no cambiar)';
$string['smtp_port']             = 'Puerto';
$string['smtp_port_help']        = 'Puerto de conexión al servidor SMTP. Los más comunes son:
<ul>
<li><strong>587</strong> — TLS (recomendado para Gmail, Outlook, Yahoo)</li>
<li><strong>465</strong> — SSL</li>
<li><strong>25</strong> — Sin cifrado (no recomendado)</li>
</ul>';
$string['smtp_security']         = 'Seguridad';
$string['smtp_security_help']    = 'Tipo de cifrado para la conexión SMTP:
<ul>
<li><strong>TLS</strong> — Recomendado. Inicia sin cifrado y lo activa (puerto 587)</li>
<li><strong>SSL</strong> — Cifrado desde el inicio de la conexión (puerto 465)</li>
<li><strong>Ninguna</strong> — Sin cifrado. Solo para servidores internos de prueba</li>
</ul>';
$string['smtp_settings']         = 'Servidor SMTP';

$string['smtp_username']         = 'Usuario';

$string['smtp_username_help']    = 'Usuario de autenticación SMTP. Generalmente es tu dirección de correo completa.
<br>Ejemplos: <code>correo@gmail.com</code>, <code>correo@tudominio.edu</code>
<br><strong>Gmail:</strong> Usa una Contraseña de Aplicación, no tu contraseña normal.';
$string['status']                = 'Estado';
$string['status_failed']         = 'Fallido';
$string['status_fallback']       = 'Fallback usado';
$string['status_sent']           = 'Enviado';
$string['subject']               = 'Asunto';
$string['task_cleanup_logs']     = 'SmartSMTP - Limpiar logs antiguos';
$string['task_reset_counters']   = 'SmartSMTP - Resetear contadores diarios';
$string['task_send_test']        = 'SmartSMTP - Enviar correo de prueba';
$string['test_connection']       = 'Probar conexión';

$string['test_email_body']       = 'Este es un correo de prueba enviado desde la cuenta SmartSMTP: {$a}';
$string['test_email_subject']    = 'SmartSMTP - Prueba de conexión';
$string['test_queued']           = 'Correo de prueba enviado. Revisa tu bandeja en unos segundos.';

$string['upgrade_to_premium']        = 'Obtener Premium';
