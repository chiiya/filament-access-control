<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Models;

use Carbon\CarbonImmutable;
use Chiiya\FilamentAccessControl\Contracts\AccessControlUser;
use Chiiya\FilamentAccessControl\Database\Factories\FilamentUserFactory;
use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Filament\Models\Contracts\FilamentUser as FilamentUserInterface;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * Chiiya\FilamentAccessControl\Models\FilamentUser.
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property null|string $name
 * @property null|Carbon|CarbonImmutable $expires_at
 * @property null|string $remember_token
 * @property null|Carbon|CarbonImmutable $created_at
 * @property null|Carbon|CarbonImmutable $updated_at
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
 *
 * @mixin \Eloquent
 */
class FilamentUser extends Authenticatable implements AccessControlUser, FilamentUserInterface, HasEmailAuthentication, HasName
{
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /** {@inheritDoc} */
    protected $table = 'filament_users';

    /** {@inheritDoc} */
    protected $hidden = ['password', 'remember_token'];

    /** {@inheritDoc} */
    protected $fillable = ['email', 'password', 'name', 'expires_at'];

    /** {@inheritDoc} */
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * {@inheritDoc}
     */
    protected static function newFactory(): FilamentUserFactory
    {
        return FilamentUserFactory::new();
    }

    /**
     * Check whether the user is a super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleName::SUPER_ADMIN);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && now()->gt($this->expires_at);
    }

    /**
     * {@inheritDoc}
     */
    public function extend(): void
    {
        $this->update([
            'expires_at' => now()->addMonths(6)->endOfDay(),
        ]);
    }

    public function hasEmailAuthentication(): bool
    {
        return Feature::enabled(Feature::TWO_FACTOR);
    }

    public function toggleEmailAuthentication(bool $condition): void
    {
        // Nothing to do
    }
}
