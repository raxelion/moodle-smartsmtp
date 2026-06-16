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
 * Portuguese language strings.
 *
 * @package    local_smartsmtp
 * @copyright  2026 Raxelion Software Strategies <contacto@raxelion.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['account']               = 'Conta';
$string['account_basic']         = 'Identificação da conta';
$string['account_created']       = 'Conta criada com sucesso';
$string['account_deleted']       = 'Conta excluída com sucesso';
$string['account_name']          = 'Nome da conta';
$string['account_notes']         = 'Notas internas';
$string['account_updated']       = 'Conta atualizada com sucesso';
$string['add_account']           = 'Adicionar conta SMTP';
$string['add_rule']              = 'Adicionar regra';
$string['all_accounts']          = 'Todas as contas';
$string['all_statuses']          = 'Todos os status';
$string['confirm_delete']        = 'Tem certeza que deseja excluir esta conta?';
$string['current_rules']             = 'Regras atuais';
$string['daily_limit']           = 'Limite de envios diários';
$string['daily_limit_help']      = 'Máximo de e-mails por dia. Use 0 para ilimitado (somente premium).';
$string['debug_mode']            = 'Modo de depuração';
$string['debug_mode_desc']       = 'Registrar atividade detalhada do SmartSMTP no debug do Moodle. Desativar em produção.';
$string['default']               = 'Padrão';
$string['disabled']              = 'Desabilitada';
$string['docs_link']             = 'Documentação completa em raxelion.com';
$string['docs_url']              = 'https://raxelion.com/smartsmtp/docs';
$string['edit_account']          = 'Editar conta SMTP';
$string['edit_blocked_reduce_accounts'] = 'Sua licença premium venceu. Para editar caixas de correio, reduza para {$a} ou menos excluindo as excedentes.';
$string['email_logs']            = 'Registros de envio de e-mail';
$string['emails_today']          = 'e-mails hoje';
$string['enabled']               = 'Habilitada';
$string['error']                 = 'Erro';
$string['error_all_full']        = 'Todas as contas SMTP atingiram o limite diário de envio.';
$string['error_no_account']      = 'Nenhuma conta SMTP disponível. Configure pelo menos uma conta.';
$string['feature_name_granularity']    = 'Granularidade por nome de notificação';
$string['feature_roundrobin']          = 'Round-robin entre caixas';
$string['feature_unlimited_mailboxes'] = 'Caixas SMTP ilimitadas';
$string['feature_unlimited_rules']     = 'Regras de roteamento ilimitadas';
$string['free_banner_desc']            = 'Versão gratuita: {$a->current} de {$a->max} contas usadas.';
$string['general_settings']      = 'Configurações gerais';
$string['invalid_limit']         = 'O limite diário deve ser 0 ou maior.';
$string['invalid_port']          = 'A porta deve ser um número entre 1 e 65535.';
$string['license_activate']          = 'Ativar';
$string['license_activated']         = 'Licença ativada com sucesso.';
$string['license_buy_now']           = 'Comprar agora';
$string['license_clear']             = 'Remover licença';
$string['license_clear_confirm']     = 'Você voltará ao plano gratuito. Continuar?';
$string['license_cleared']           = 'Licença removida. Você está no plano gratuito.';
$string['license_days_left']            = '{$a} dias restantes';
$string['license_domain']            = 'Domínio licenciado';
$string['license_enter_key']         = 'Ativar licença';
$string['license_expired_accounts_desc'] = 'Sua licença venceu e você tem {$a->count} caixas configuradas (limite: {$a->max}). A edição está bloqueada até reduzir para {$a->max} ou menos, ou renovar sua licença.';
$string['license_expired_desc']         = 'Sua licença premium venceu. O plugin voltou ao plano gratuito.';
$string['license_expired_title']        = 'Licença premium vencida';
$string['license_expires']           = 'Vence em';
$string['license_expiring_desc']        = 'Sua licença premium vence em {$a->days} dias. Renove agora para evitar interrupções.';
$string['license_expiring_title']       = 'Licença prestes a vencer';
$string['license_features']          = 'Funções incluídas';
$string['license_get_premium']       = 'Obter SmartSMTP Premium';
$string['license_how_works_desc']    = 'A licença é verificada localmente usando assinatura criptográfica RSA. Não requer conexão com a internet. A chave fica vinculada ao domínio do seu site Moodle.';
$string['license_how_works_title']   = 'Como funciona a licença:';
$string['license_invalid_key']       = 'A chave de licença é inválida ou não corresponde a este domínio.';
$string['license_key']           = 'Chave de licença premium';
$string['license_key_desc']      = 'Insira sua chave de licença para desbloquear funções premium.';
$string['license_key_placeholder']   = 'Cole sua chave de licença aqui...';
$string['license_management']        = 'Licença premium';
$string['license_premium_desc']      = 'Desbloqueie todas as funções avançadas por $79 USD/site/ano.';
$string['license_price']             = '$79 USD / site / ano';
$string['license_renew']                = 'Renovar licença';
$string['license_status_active']     = 'Licença ativa';
$string['license_status_free']       = 'Plano gratuito';
$string['license_status_invalid']    = 'Chave inválida';
$string['log_retention_days']    = 'Retenção de logs (dias)';
$string['log_retention_days_desc'] = 'Logs mais antigos que este número de dias serão excluídos automaticamente. Padrão: 90.';
$string['manage_accounts']       = 'Gerenciar contas SMTP';
$string['manage_rules']          = 'Regras de notificação';
$string['max_accounts_reached']  = 'Você atingiu o limite de contas para a versão gratuita.';
$string['max_rules_reached']         = 'Limite de regras atingido no plano gratuito.';
$string['max_rules_reached_detail']  = 'O plano gratuito permite no máximo 2 regras.';
$string['need_account_for_rules'] = 'Você precisa de pelo menos uma conta SMTP habilitada antes de adicionar regras.';
$string['no_accounts_yet']       = 'Nenhuma conta SMTP configurada. Adicione sua primeira conta.';
$string['no_logs_yet']           = 'Nenhum registro de envio ainda.';
$string['no_rules_yet']          = 'Nenhuma regra configurada. Todos os e-mails usarão a conta padrão.';
$string['non_interceptable_desc']    = 'Os e-mails de recuperação de senha e cadastro sempre usam a caixa padrão. Não podem ser redirecionados por regras.';
$string['non_interceptable_title']   = 'Nota:';
$string['noreply_email']         = 'E-mail noreply';
$string['noreply_email_help']    = 'E-mail que aparece como remetente nas mensagens do sistema. Se deixado em branco, usa o usuário SMTP da caixa. Exemplo: nao-responda@suauniversidade.edu.br';
$string['noreply_name']          = 'Nome do remetente';
$string['noreply_name_help']     = 'Nome visível no campo "De:" dos e-mails. Exemplo: Universidade XYZ';
$string['noreply_note']          = 'Estes valores são aplicados quando esta caixa é a padrão. Afeta e-mails do sistema incluindo recuperação de senha.';
$string['noreply_settings']      = 'Configuração do remetente (noreply)';
$string['notes']                 = 'Notas';
$string['password_leave_blank']  = 'Deixe o campo de senha em branco se não quiser alterá-la.';
$string['pluginname']            = 'SmartSMTP Manager';
$string['premium_badge']             = 'Premium';
$string['premium_only_short']        = 'premium';
$string['premium_required']      = 'Esta função requer uma licença premium.';
$string['premium_url']           = 'https://raxelion.com/smartsmtp-premium';
$string['priority_help']         = 'Número maior = maior prioridade. Padrão: 0.';
$string['privacy:metadata']      = 'SmartSMTP Manager não armazena dados pessoais diretamente. Armazena credenciais de servidor SMTP e registros de envio de e-mail com fins administrativos.';
$string['privacy:metadata:smartsmtp_logs']           = 'SmartSMTP armazena registros de envio de e-mail para fins administrativos.';
$string['privacy:metadata:smartsmtp_logs:recipient'] = 'O endereço de e-mail do destinatário.';
$string['privacy:metadata:smartsmtp_logs:status']    = 'Se o e-mail foi enviado com sucesso ou falhou.';
$string['privacy:metadata:smartsmtp_logs:subject']   = 'O assunto do e-mail enviado.';
$string['privacy:metadata:smartsmtp_logs:timesent']  = 'O horário em que o e-mail foi enviado.';
$string['recipient']             = 'Destinatário';
$string['rule_account']          = 'Conta SMTP';
$string['rule_added']            = 'Regra adicionada com sucesso';
$string['rule_comp_analytics']       = 'Análises';
$string['rule_comp_assign']          = 'Tarefas';
$string['rule_comp_badges']          = 'Medalhas';
$string['rule_comp_calendar']        = 'Calendário';
$string['rule_comp_chat']            = 'Chat';
$string['rule_comp_data']            = 'Banco de dados';
$string['rule_comp_enrol_manual']    = 'Matrícula manual';
$string['rule_comp_enrol_self']      = 'Matrícula voluntária';
$string['rule_comp_feedback']        = 'Feedback';
$string['rule_comp_forum']           = 'Fóruns';
$string['rule_comp_lesson']          = 'Lição';
$string['rule_comp_message']         = 'Mensagens internas';
$string['rule_comp_monitor']         = 'Monitor de eventos';
$string['rule_comp_quiz']            = 'Questionários';
$string['rule_comp_workshop']        = 'Oficina';
$string['rule_component']            = 'Componente';
$string['rule_component_any']        = 'Qualquer notificação (fallback — exclui senhas e cadastros)';
$string['rule_component_help']       = 'Selecione o módulo do Moodle cujos e-mails deseja rotear por uma caixa específica. Se selecionar "Qualquer notificação", esta regra se aplica a todos os e-mails sem uma regra mais específica.';
$string['rule_deleted']          = 'Regra excluída com sucesso';
$string['rule_name_field']           = 'Nome técnico da notificação (opcional)';
$string['rule_name_help']            = 'Filtro técnico avançado. Deixe VAZIO para aplicar a regra a TODO o componente.';
$string['rule_name_help_free']       = 'Disponível no Premium. Permite filtrar por tipo exato de notificação dentro do componente.';
$string['rule_name_placeholder']     = 'ex: posts, due_date, assign_notification';
$string['rule_notification_type'] = 'Tipo de notificação';
$string['rule_priority']         = 'Prioridade';
$string['rule_roundrobin']           = 'Round-robin';
$string['rule_roundrobin_help']      = 'Alterna entre várias caixas com a mesma regra. Distribui a carga automaticamente.';
$string['rule_roundrobin_help_free'] = 'Disponível no Premium. Distribui e-mails entre várias caixas automaticamente.';
$string['rules_count_free']          = '{$a->current} de {$a->max} regras (plano Free)';
$string['rules_count_premium']       = '{$a} regras configuradas';
$string['rules_priority_example'] = 'Exemplo de prioridades:
<ul>
<li><strong>Prioridade 3</strong> — mod_assign → Gmail</li>
<li><strong>Prioridade 2</strong> — mod_forum → Yahoo</li>
<li><strong>Prioridade 1</strong> — Qualquer notificação → Gmail (fallback)</li>
</ul>';
$string['security_none']         = 'Nenhuma';
$string['sending_limits']        = 'Limites de envio';
$string['set_as_default']        = 'Definir como conta padrão';
$string['set_as_default_help']   = 'A caixa padrão é usada para:
<ul>
<li>E-mails de recuperação de senha</li>
<li>E-mails de registro de novos usuários</li>
<li>Qualquer e-mail sem regra de roteamento correspondente</li>
</ul>';
$string['smartsmtp:manageaccounts'] = 'Gerenciar contas SmartSMTP';
$string['smartsmtp:viewlogs']       = 'Ver registros de envio SmartSMTP';
$string['smtp_auth']             = 'Autenticação';
$string['smtp_host']             = 'Servidor SMTP';
$string['smtp_host_help']        = 'Endereço do servidor SMTP. Exemplos: smtp.gmail.com, smtp.office365.com';
$string['smtp_password']         = 'Senha';
$string['smtp_password_change']  = 'Nova senha (deixe em branco para não alterar)';
$string['smtp_port']             = 'Porta';
$string['smtp_port_help']        = 'Porta de conexão ao servidor SMTP. Portas comuns:
<ul>
<li><strong>587</strong> — TLS (recomendado para Gmail, Outlook, Yahoo)</li>
<li><strong>465</strong> — SSL</li>
<li><strong>25</strong> — Sem criptografia (não recomendado)</li>
</ul>';
$string['smtp_security']         = 'Segurança';
$string['smtp_security_help']    = 'Tipo de criptografia para a conexão SMTP:
<ul>
<li><strong>TLS</strong> — Recomendado. Inicia sem criptografia e a ativa (porta 587)</li>
<li><strong>SSL</strong> — Criptografado desde o início (porta 465)</li>
<li><strong>Nenhuma</strong> — Apenas para servidores de teste internos</li>
</ul>';
$string['smtp_settings']         = 'Servidor SMTP';
$string['smtp_username']         = 'Usuário';
$string['smtp_username_help']    = 'Nome de usuário SMTP. Geralmente seu endereço de e-mail completo.
<br>Exemplos: <code>mail@gmail.com</code>, <code>mail@suauniversidade.edu.br</code>';
$string['status']                = 'Status';
$string['status_failed']         = 'Falhou';
$string['status_fallback']       = 'Fallback usado';
$string['status_sent']           = 'Enviado';
$string['subject']               = 'Assunto';
$string['task_cleanup_logs']     = 'SmartSMTP - Limpar logs antigos';
$string['task_reset_counters']   = 'SmartSMTP - Reiniciar contadores diários';
$string['task_send_test']        = 'SmartSMTP - Enviar e-mail de teste';
$string['test_connection']       = 'Testar conexão';

$string['test_email_body']       = 'Este é um e-mail de teste enviado da conta SmartSMTP: {$a}';
$string['test_email_subject']    = 'SmartSMTP - Teste de conexão';
$string['test_queued']           = 'E-mail de teste enviado. Verifique sua caixa de entrada em alguns segundos.';

$string['upgrade_to_premium']        = 'Obter Premium';
