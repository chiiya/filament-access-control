<?php

namespace Chiiya\FilamentAccessControl\Enumerators;

enum Feature
{
    case ACCOUNT_EXPIRY;

    public function enabled(): bool
    {
        return in_array($this, config('filament-access-control.features'), true);
    }
}
