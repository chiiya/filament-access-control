<?php

return [
    'fields' => [
        'first_name' => 'Nombre',
        'last_name' => 'Apellido',
        'email' => 'Correo electrónico',
        'role' => 'Rol',
        'permissions' => 'Permisos',
        'name' => 'Nombre',
        'full_name' => 'Nombre completo',
        'description' => 'Descripción',
        'id' => 'ID',
        'created_at' => 'Creado el',
        'password' => 'Contraseña',
        'password_confirm' => 'Confirmar contraseña',
        'active' => 'Activo',
        'expires_at' => 'Fecha de vencimiento',
        'code' => 'Código de verificación',
    ],
    'resources' => [
        'admin_user' => 'Usuario administrador',
        'admin_users' => 'Usuarios administradores',
        'role' => 'Rol',
        'roles' => 'Roles',
        'permission' => 'Permiso',
        'permissions' => 'Permisos',
        'group' => 'Administración',
    ],
    'sections' => [
        'permissions' => 'Permisos',
        'user_details' => 'Detalles del usuario',
    ],
    'messages' => [
        'permissions_create' => 'Los usuarios pueden tener otros permisos a través de su rol. Los permisos reales se enumeran en la página de visualización.',
        'permissions_view' => 'Permisos directos así como permisos a través de su rol.',
        'account_expired' => 'Esta cuenta ha expirado. Por favor, contacta a un administrador.',
        'accounts_extended' => 'Las cuentas seleccionadas han sido extendidas.',
        'account_extended' => 'La cuenta seleccionada ha sido extendida.',
        'invalid_user' => 'Usuario inválido, por favor intenta de nuevo.',
        'code_expired' => 'Este código de verificación ha expirado. Por favor, usa el nuevo código que te acabamos de enviar.',
        'invalid_code' => 'Código de verificación inválido.',
        'enter_code' => 'Para confirmar tu inicio de sesión, por favor ingresa el código de verificación enviado a tu dirección de correo electrónico.',
        'password_reset_link_sent' => '¡Enlace de restablecimiento de contraseña enviado!',
    ],
    'pages' => [
        'reset_password' => 'Restablecer contraseña',
        'account_expired' => 'Cuenta expirada',
        'two_factor' => 'Verificación de inicio de sesión',
    ],
    'notifications' => [
        'salutation' => 'Saludos',
        'password_reset' => [
            'title' => 'Tu contraseña para el administrador de :host',
            'message' => 'Recibes este correo porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.',
            'button' => 'Restablecer Contraseña',
            'expiry' => 'Este enlace de restablecimiento de contraseña expirará en :count minutos. Si no solicitaste un restablecimiento de contraseña, no se requiere ninguna acción adicional.',
        ],
        'password_set' => [
            'title' => 'Tu cuenta para el administrador de :host',
            'message' => 'Recibes este correo porque recientemente se creó una cuenta de administrador para ti para el administrador de :host. Por favor, haz clic en el siguiente enlace para establecer tu contraseña:',
            'button' => 'Establecer Contraseña',
            'expiry' => 'Este enlace para establecer la contraseña expirará en :count minutos. Si el enlace ha expirado, puedes intentar [restablecer tu contraseña manualmente](:url).',
        ],
        'two_factor' => [
            'title' => 'Tu código de verificación para el administrador de :host',
            'message' => 'Para confirmar tu inicio de sesión, por favor usa el siguiente código de verificación. El código es válido durante 5 minutos.',
        ],
    ],
    'buttons' => [
        'back_to_login' => 'Volver al inicio de sesión',
        'forgot_password' => '¿Olvidaste tu contraseña?',
        'submit' => 'Enviar',
    ],
    'filters' => [
        'expired' => 'Expirado',
    ],
    'actions' => [
        'extend' => 'Extender la fecha de vencimiento',
        'reset_password' => 'Restablecer contraseña',
    ],
];
