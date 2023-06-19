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

    /**
     * Has a two-factor code already been created?
     */
    public function hasTwoFactorCode(): bool;

    /**
     * Get the users two-factor code.
     */
    public function getTwoFactorCode(): ?string;

    /**
     * Has the two-factor authentication code expired?
     */
    public function twoFactorCodeIsExpired(): bool;

    /**
     * Send email with two-factor code.
     */
    public function sendTwoFactorCodeNotification(): void;
}
