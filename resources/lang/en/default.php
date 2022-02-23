<?php

return [
    'fields' => [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email',
        'role' => 'Role',
        'permissions' => 'Permissions',
        'name' => 'Name',
        'full_name' => 'Name',
        'description' => 'Description',
        'id' => 'ID',
        'created_at' => 'Created At',
        'password' => 'Password',
        'password_confirm' => 'Confirm password',
        'active' => 'Active',
        'expires_at' => 'Expiry Date',
    ],
    'resources' => [
        'admin_user' => 'Admin User',
        'admin_users' => 'Admin Users',
        'role' => 'Role',
        'roles' => 'Roles',
        'permission' => 'Permission',
        'permissions' => 'Permissions',
        'group' => 'Administration',
    ],
    'sections' => [
        'permissions' => 'Permissions',
        'user_details' => 'User Details',
    ],
    'messages' => [
        'permissions_create' => 'Users may have other permissions from their role. The actual permissions are listed on the view page.',
        'permissions_view' => 'Direct permissions as well as permissions through their role.',
        'account_expired' => 'This account is expired. Please contact an administrator.',
        'accounts_extended' => 'The selected accounts have been extended.',
    ],
    'pages' => [
        'reset_password' => 'Reset password',
        'account_expired' => 'Account expired',
    ],
    'notifications' => [
        'password_reset' => [
            'title' => 'Your password for the :host admin',
        ],
        'password_set' => [
            'title' => 'Your account for the :host admin',
            'message' => 'You are receiving this email because an admin account was recently created for you for the :host admin. Please click on the following link to set your personal password:',
            'button' => 'Set Password',
        ],
    ],
    'buttons' => [
        'back_to_login' => 'Back to login',
        'forgot_password' => 'Forgot password?',
        'submit' => 'Submit',
    ],
    'filters' => [
        'expired' => 'Expired',
    ],
    'actions' => [
        'extend' => 'Extend expiry date',
    ],
];
