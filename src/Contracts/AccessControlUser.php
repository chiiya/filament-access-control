<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Contracts;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;

interface AccessControlUser extends Authenticatable, Authorizable
{
    /**
     * Check whether the account is expired.
     */
    public function isExpired(): bool;

    /**
     * Extend the account expiry date.
     */
    public function extend(): void;
}
