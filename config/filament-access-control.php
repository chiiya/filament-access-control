<?php

use Chiiya\FilamentAccessControl\Models\FilamentUser;
return [
    /*
    |--------------------------------------------------------------------------
    | List of enabled features
    |--------------------------------------------------------------------------
    | The following features are available:
    | \Chiiya\FilamentAccessControl\Enumerators\Feature::ACCOUNT_EXPIRY
    | \Chiiya\FilamentAccessControl\Enumerators\Feature::TWO_FACTOR
    */
    'features' => [
        //        \Chiiya\FilamentAccessControl\Enumerators\Feature::ACCOUNT_EXPIRY,
        //        \Chiiya\FilamentAccessControl\Enumerators\Feature::TWO_FACTOR,
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Rules
    |--------------------------------------------------------------------------
    | Rules for the password set during the password reset flow.
    */
    'password_rules' => ['min:8'],

    /*
    |--------------------------------------------------------------------------
    | Password Hint
    |--------------------------------------------------------------------------
    | Helper text displayed when setting a new password on the password-reset
    | page. Useful for hinting at complex password requirements.
    */
    'password_hint' => null,

    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    | Display format for datepicker
    */
    'date_format' => 'd.m.Y',

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    | User model used for admin access and management.
    */
    'user_model' => FilamentUser::class,
];
