<?php

return [
    'fields' => [
        'first_name' => 'Prénom',
        'last_name' => 'Nom de famille',
        'email' => 'Email',
        'role' => 'Rôle',
        'permissions' => 'Permissions',
        'name' => 'Nom',
        'full_name' => 'Nom complet',
        'description' => 'Description',
        'id' => 'ID',
        'created_at' => 'Créé le',
        'password' => 'Mot de passe',
        'password_confirm' => 'Confirmer le mot de passe',
        'active' => 'Actif',
        'expires_at' => 'Date d\'expiration',
        'code' => 'Code de vérification',
    ],
    'resources' => [
        'admin_user' => 'Utilisateur admin',
        'admin_users' => 'Utilisateurs admin',
        'role' => 'Rôle',
        'roles' => 'Rôles',
        'permission' => 'Permission',
        'permissions' => 'Permissions',
        'group' => 'Administration',
    ],
    'sections' => [
        'permissions' => 'Permissions',
        'user_details' => 'Détails de l\'utilisateur',
    ],
    'messages' => [
        'permissions_create' => 'Les utilisateurs peuvent avoir d\'autres permissions via leur rôle. Les permissions réelles sont listées sur la page de visualisation.',
        'permissions_view' => 'Permissions directes ainsi que permissions via leur rôle.',
        'account_expired' => 'Ce compte est expiré. Veuillez contacter un administrateur.',
        'accounts_extended' => 'Les comptes sélectionnés ont été prolongés.',
        'account_extended' => 'Le compte sélectionné a été prolongé.',
        'invalid_user' => 'Utilisateur invalide, veuillez réessayer.',
        'code_expired' => 'Ce code de vérification a expiré. Veuillez utiliser le nouveau code que nous venons de vous envoyer.',
        'invalid_code' => 'Code de vérification invalide.',
        'enter_code' => 'Pour confirmer votre connexion, veuillez entrer le code de vérification envoyé à votre adresse email.',
        'password_reset_link_sent' => 'Lien de réinitialisation du mot de passe envoyé !',
    ],
    'pages' => [
        'reset_password' => 'Réinitialiser le mot de passe',
        'account_expired' => 'Compte expiré',
        'two_factor' => 'Vérification de connexion',
    ],
    'notifications' => [
        'salutation' => 'Cordialement',
        'password_reset' => [
            'title' => 'Votre mot de passe pour l\'admin :host',
            'message' => 'Vous recevez cet email car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.',
            'button' => 'Réinitialiser le mot de passe',
            'expiry' => 'Ce lien de réinitialisation du mot de passe expirera dans :count minutes. Si vous n\'avez pas demandé de réinitialisation, aucune action supplémentaire n\'est requise.',
        ],
        'password_set' => [
            'title' => 'Votre compte pour l\'admin :host',
            'message' => 'Vous recevez cet email car un compte admin a été récemment créé pour vous pour l\'admin :host. Veuillez cliquer sur le lien suivant pour définir votre mot de passe :',
            'button' => 'Définir le mot de passe',
            'expiry' => 'Ce lien de définition du mot de passe expirera dans :count minutes. Si le lien a expiré, vous pouvez essayer de [réinitialiser votre mot de passe manuellement](:url).',
        ],
        'two_factor' => [
            'title' => 'Votre code de vérification pour l\'admin :host',
            'message' => 'Pour confirmer votre connexion, veuillez utiliser le code de vérification suivant. Le code est valide pendant 5 minutes.',
        ],
    ],
    'buttons' => [
        'back_to_login' => 'Retour à la connexion',
        'forgot_password' => 'Mot de passe oublié ?',
        'submit' => 'Soumettre',
    ],
    'filters' => [
        'expired' => 'Expiré',
    ],
    'actions' => [
        'extend' => 'Prolonger la date d\'expiration',
        'reset_password' => 'Réinitialiser le mot de passe',
    ],
];
