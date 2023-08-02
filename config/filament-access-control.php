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
