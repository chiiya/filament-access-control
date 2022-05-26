<?php

declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Enumerators;

class Feature
{
    public const ACCOUNT_EXPIRY = 'account_expiry';
    public const TWO_FACTOR = 'two_factor';

    public static function enabled($feature): bool
    {
        return in_array($feature, config('filament-access-control.features'), true);
    }
}
