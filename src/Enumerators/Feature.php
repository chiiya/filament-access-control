<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Enumerators;

enum Feature
{
    case ACCOUNT_EXPIRY;
    case TWO_FACTOR;
    public function enabled(): bool
    {
        return in_array($this, config('filament-access-control.features'), true);
    }
}
