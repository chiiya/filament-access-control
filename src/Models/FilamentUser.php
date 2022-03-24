<?php

namespace Chiiya\FilamentAccessControl\Models;

use Carbon\Carbon;
use Chiiya\FilamentAccessControl\Database\Factories\FilamentUserFactory;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Chiiya\FilamentAccessControl\Notifications\ResetPassword;
use Filament\Models\Contracts\FilamentUser as FilamentUserInterface;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * Chiiya\FilamentAccessControl\Models\FilamentUser.
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property null|string $first_name
 * @property null|string $last_name
 * @property null|\Illuminate\Support\Carbon $expires_at
 * @property null|string $two_factor_code
 * @property null|\Illuminate\Support\Carbon $two_factor_expires_at
 * @property null|string $remember_token
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property string $full_name
 * @property DatabaseNotification[]|DatabaseNotificationCollection $notifications
 * @property null|int $notifications_count
 * @property Collection|Permission[] $permissions
 * @property null|int $permissions_count
 * @property Collection|Role[] $roles
 * @property null|int $roles_count
 *
 * @method static Builder|FilamentUser newModelQuery()
 * @method static Builder|FilamentUser newQuery()
 * @method static Builder|FilamentUser permission($permissions)
 * @method static Builder|FilamentUser query()
 * @method static Builder|FilamentUser role($roles, $guard = null)
 * @mixin \Eloquent
 */
class FilamentUser extends Authenticatable implements FilamentUserInterface, HasName
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /** {@inheritDoc} */
    protected $table = 'filament_users';

    /** {@inheritDoc} */
    protected $hidden = ['password', 'remember_token'];

    /** {@inheritDoc} */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'expires_at',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /** {@inheritDoc} */
    protected $casts = [
        'expires_at' => 'datetime',
        'two_factor_expires_at' => 'datetime',
    ];

    /**
     * {@inheritDoc}
     */
    protected static function newFactory(): FilamentUserFactory
    {
        return FilamentUserFactory::new();
    }

    /**
     * Check whether the account is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && now()->gt($this->expires_at);
    }

    /**
     * Check whether the user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleName::SUPER_ADMIN);
    }

    /**
     * Provides full name of the current filament user.
     */
    public function getFullNameAttribute(): string
    {
        if (! $this->first_name && ! $this->last_name) {
            return '—';
        }

        $name = $this->first_name ?? '';

        if ($this->last_name) {
            $name .= ' '.$this->last_name;
        }

        return $name;
    }

    public function canAccessFilament(): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->full_name;
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Extend the expiry date.
     */
    public function extend(): void
    {
        $this->update([
            'expires_at' => now()->addMonths(6)->endOfDay(),
        ]);
    }

    /**
     * Has a two-factor code already been created?
     */
    public function hasTwoFactorCode(): bool
    {
        return $this->two_factor_code !== null;
    }

    /**
     * Has the two-factor authentication code expired?
     */
    public function twoFactorCodeIsExpired(): bool
    {
        return $this->two_factor_expires_at instanceof Carbon && now()->gt($this->two_factor_expires_at);
    }
}
