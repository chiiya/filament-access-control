<?php

return [
    /*
    |--------------------------------------------------------------------------
    | List of enabled features
    |--------------------------------------------------------------------------
    | The following features are available:
    | \Chiiya\FilamentAccessControl\Enumerators\Feature::ACCOUNT_EXPIRY
    */
    'features' => [\Chiiya\FilamentAccessControl\Enumerators\Feature::ACCOUNT_EXPIRY],

    /*
    |--------------------------------------------------------------------------
    | Password Rules
    |--------------------------------------------------------------------------
    | Rules for the password set during the passwort reset flow.
    */
    'password_rules' => [\Illuminate\Validation\Rules\Password::min(8)],

    /*
    |--------------------------------------------------------------------------
    | Date Format
    |--------------------------------------------------------------------------
    | Display format for datepicker
    */
    'date_format' => 'd.m.Y',
];
