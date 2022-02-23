<?php

return [
    'fields' => [
        'first_name' => 'Vorname',
        'last_name' => 'Nachname',
        'email' => 'E-Mail Adresse',
        'role' => 'Rolle',
        'permissions' => 'Berechtigungen',
        'name' => 'Name',
        'full_name' => 'Name',
        'description' => 'Beschreibung',
        'id' => 'ID',
        'created_at' => 'Erstellungsdatum',
        'password' => 'Passwort',
        'password_confirm' => 'Passwort bestätigen',
        'active' => 'Aktiv',
        'expires_at' => 'Ablaufdatum',
    ],
    'resources' => [
        'admin_user' => 'Admin User',
        'admin_users' => 'Admin User',
        'role' => 'Rolle',
        'roles' => 'Rollen',
        'permission' => 'Berechtigung',
        'permissions' => 'Berechtigungen',
        'group' => 'Administration',
    ],
    'sections' => [
        'permissions' => 'Berechtigungen',
        'user_details' => 'Benutzerdaten',
    ],
    'messages' => [
        'permissions_create' => 'Benutzer können aufgrund ihrer Rolle über andere Berechtigungen verfügen. Die tatsächlichen Berechtigungen sind auf der Detailansicht des Benutzers aufgelistet.',
        'permissions_view' => 'Direkte Berechtigungen sowie Berechtigungen über die Rolle.',
        'account_expired' => 'Dieser Account ist abgelaufen. Bitte kontaktieren Sie einen Administrator.',
        'accounts_extended' => 'Die ausgewählten Accounts wurden erfolgreich verlängert.',
    ],
    'pages' => [
        'reset_password' => 'Passwort zurücksetzen',
        'account_expired' => 'Account abgelaufen',
    ],
    'notifications' => [
        'password_reset' => [
            'title' => 'Ihr Passwort für die :host Admin',
        ],
        'password_set' => [
            'title' => 'Ihr Account für die :host Admin',
            'message' => 'Sie erhalten diese E-Mail, weil für Sie kürzlich ein Konto für die :host Admin erstellt wurde. Bitte klicken Sie auf den folgenden Link um Ihr persönliches Passwort festzulegen:',
            'button' => 'Passwort setzen',
        ],
    ],
    'buttons' => [
        'back_to_login' => 'Zurück zum Login',
        'forgot_password' => 'Passwort vergessen?',
        'submit' => 'Absenden',
    ],
    'filters' => [
        'expired' => 'Abgelaufen',
    ],
    'actions' => [
        'extend' => 'Account verlängern',
    ],
];
