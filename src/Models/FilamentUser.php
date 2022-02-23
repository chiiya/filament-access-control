<?php

namespace Chiiya\FilamentAccessControl\Models;

use Chiiya\FilamentAccessControl\Database\Factories\FilamentUserFactory;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Chiiya\FilamentAccessControl\Notifications\ResetPassword;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
 * @property null|string $remember_token
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|\Illuminate\Support\Carbon $deleted_at
 * @property string $full_name
 * @property \Illuminate\Notifications\DatabaseNotification[]|\Illuminate\Notifications\DatabaseNotificationCollection $notifications
 * @property null|int $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property null|int $permissions_count
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property null|int $roles_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|FilamentUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilamentUser newQuery()
 * @method static \Illuminate\Database\Query\Builder|FilamentUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FilamentUser permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|FilamentUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilamentUser role($roles, $guard = null)
 * @method static \Illuminate\Database\Query\Builder|FilamentUser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FilamentUser withoutTrashed()
 * @mixin \Eloquent
 */
class FilamentUser extends Authenticatable implements \Filament\Models\Contracts\FilamentUser, HasName
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    /**
     * Database table name.
     *
     * @var string
     */
    protected $table = 'filament_users';

    /**
     * Attributes excluded from JSON responses.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Attributes that are mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check whether the account is expired.
     */
    public function isExpired(): bool
    {
        return now()->gt($this->expires_at);
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
     * @inheritDoc
     */
    protected static function newFactory(): FilamentUserFactory
    {
        return FilamentUserFactory::new();
    }
}
