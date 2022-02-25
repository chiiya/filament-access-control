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
        'code' => 'Verification code',
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
        'invalid_user' => 'Invalid user, please try again.',
        'code_expired' => 'This verification code has expired. Please use the new code that we have just sent you.',
        'invalid_code' => 'Invalid verification code.',
        'enter_code' => 'To confirm your login, please enter the verification code sent to your email address.',
    ],
    'pages' => [
        'reset_password' => 'Reset password',
        'account_expired' => 'Account expired',
        'two_factor' => 'Login verification',
    ],
    'notifications' => [
        'salutation' => 'Regards',
        'password_reset' => [
            'title' => 'Your password for the :host admin',
            'message' => 'You are receiving this email because we received a password reset request for your account.',
            'button' => 'Reset Password',
            'expiry' => 'This password reset link will expire in :count minutes. If you did not request a password reset, no further action is required.',
        ],
        'password_set' => [
            'title' => 'Your account for the :host admin',
            'message' => 'You are receiving this email because an admin account was recently created for you for the :host admin. Please click on the following link to set your password:',
            'button' => 'Set Password',
            'expiry' => 'This password set link will expire in :count minutes. Should the link have expired, you can attempt to [reset your password manually](:url).',
        ],
        'two_factor' => [
            'title' => 'Your verification code for the :host admin',
            'message' => 'To confirm your login, please use the following verification code. The code is valid for 5 minutes.',
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
