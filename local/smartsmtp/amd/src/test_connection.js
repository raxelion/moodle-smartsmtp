// amd/src/test_connection.js
define(['core/ajax', 'core/notification', 'core/str'], function(Ajax, Notification, Str) {

    return {
        init: function(accountId, buttonSelector) {
            const btn = document.querySelector(buttonSelector);
            if (!btn) return;

            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const toEmail = prompt(
                    'Ingresa el correo de destino para la prueba:',
                    ''
                );
                if (!toEmail) return;

                btn.disabled = true;
                btn.textContent = 'Probando...';

                Ajax.call([{
                    methodname: 'local_smartsmtp_test_connection',
                    args: {
                        account_id: accountId,
                        to_email:   toEmail
                    }
                }])[0].then(function(result) {
                    if (result.success) {
                        Notification.addNotification({
                            message: 'Correo de prueba enviado correctamente a ' + toEmail,
                            type:    'success'
                        });
                    } else {
                        Notification.addNotification({
                            message: 'Error al enviar: ' + result.error,
                            type:    'error'
                        });
                    }
                    btn.disabled    = false;
                    btn.textContent = 'Probar conexión';
                    return result;
                }).catch(function(err) {
                    Notification.exception(err);
                    btn.disabled    = false;
                    btn.textContent = 'Probar conexión';
                });
            });
        }
    };
});