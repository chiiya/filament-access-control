<?php declare(strict_types=1);

use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Chiiya\FilamentAccessControl\Resources\RoleResource;

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
    | Guard Name
    |--------------------------------------------------------------------------
    | Auth guard name used for the admin panel.
    */
    'guard_name' => 'filament',

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    | User model used for admin access and management.
    */
    'user_model' => FilamentUser::class,

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    | Resources used for managing users, roles and permissions.
    */
    'resources' => [
        'user' => FilamentUserResource::class,
        'role' => RoleResource::class,
        'permission' => PermissionResource::class,
    ],
];
