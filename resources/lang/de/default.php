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
        'code' => 'Verifizierungscode',
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
        'invalid_user' => 'Ungültiger Benutzer, bitte versuchen Sie es erneut.',
        'code_expired' => 'Dieser Verifizierungscode ist abgelaufen. Bitte verwenden Sie den neuen Code, den wir Ihnen gerade geschickt haben.',
        'invalid_code' => 'Ungültiger Verifizierungscode.',
        'enter_code' => 'Bitte geben Sie zur Bestätigung Ihres Logins den Verifizierungscode ein, der an Ihre E-Mail Adresse geschickt wurde.',
    ],
    'pages' => [
        'reset_password' => 'Passwort zurücksetzen',
        'account_expired' => 'Account abgelaufen',
        'two_factor' => 'Login-Verifizierung',
    ],
    'notifications' => [
        'salutation' => 'Vielen Dank',
        'password_reset' => [
            'title' => 'Ihr Passwort für die :host Admin',
            'message' => 'Sie erhalten diese E-Mail, weil wir einen Antrag auf eine Zurücksetzung Ihres Passworts bekommen haben.',
            'button' => 'Passwort zurücksetzen',
            'expiry' => 'Dieser Link zum Zurücksetzen des Passworts läuft in :count Minuten ab. Wenn Sie kein Zurücksetzen des Passworts beantragt haben, sind keine weiteren Handlungen nötig.',
        ],
        'password_set' => [
            'title' => 'Ihr Account für die :host Admin',
            'message' => 'Sie erhalten diese E-Mail, weil für Sie kürzlich ein Konto für die :host Admin erstellt wurde. Bitte klicken Sie auf den folgenden Link um Ihr persönliches Passwort festzulegen:',
            'button' => 'Passwort setzen',
            'expiry' => 'Dieser Link zum Setzen des Passworts läuft in :count Minuten ab. Sollte der Link abgelaufen sein, können Sie versuchen, Ihr Passwort [manuell zurückzusetzen](:url).',
        ],
        'two_factor' => [
            'title' => 'Ihr Verifizierungscode für die :host Admin',
            'message' => 'Um Ihren Login zu bestätigen, verwenden Sie bitte den folgenden Verifizierungscode. Der Code ist 5 Minuten lang gültig.',
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
