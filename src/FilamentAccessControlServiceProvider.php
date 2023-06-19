<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl;

use Chiiya\FilamentAccessControl\Commands\CreateFilamentUser;
use Chiiya\FilamentAccessControl\Commands\Install;
use Chiiya\FilamentAccessControl\Http\Livewire\AccountExpired;
use Chiiya\FilamentAccessControl\Http\Livewire\ForgotPassword;
use Chiiya\FilamentAccessControl\Http\Livewire\Login;
use Chiiya\FilamentAccessControl\Http\Livewire\ResetPassword;
use Chiiya\FilamentAccessControl\Http\Livewire\TwoFactorChallenge;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Chiiya\FilamentAccessControl\Policies\FilamentUserPolicy;
use Chiiya\FilamentAccessControl\Policies\PermissionPolicy;
use Chiiya\FilamentAccessControl\Policies\RolePolicy;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Chiiya\FilamentAccessControl\Resources\RoleResource;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FilamentAccessControlServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-access-control')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasRoutes('web')
            ->hasMigration('create_filament_users_table')
            ->hasMigration('create_filament_password_resets_table')
            ->hasViews('filament-access-control')
            ->hasCommand(CreateFilamentUser::class)
            ->hasCommand(Install::class);
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();
        $this->mergeGuardsConfig();
        $this->mergeProvidersConfig();
        $this->mergePasswordsConfig();
    }

    public function packageBooted(): void
    {
        parent::packageBooted();
        Livewire::component(Login::getName(), Login::class);
        Livewire::component(ForgotPassword::getName(), ForgotPassword::class);
        Livewire::component(ResetPassword::getName(), ResetPassword::class);
        Livewire::component(AccountExpired::getName(), AccountExpired::class);
        Livewire::component(TwoFactorChallenge::getName(), TwoFactorChallenge::class);
        Gate::policy(config('filament-access-control.user_model'), FilamentUserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
    }

    protected function getResources(): array
    {
        return [FilamentUserResource::class, PermissionResource::class, RoleResource::class];
    }

    /**
     * Merge auth guards configuration.
     */
    protected function mergeGuardsConfig(): void
    {
        $this->mergeConfig([
            'filament' => [
                'driver' => 'session',
                'provider' => 'filament_users',
            ],
        ], 'auth.guards');
    }

    /**
     * Merge auth providers configuration.
     */
    protected function mergeProvidersConfig(): void
    {
        $this->mergeConfig([
            'filament_users' => [
                'driver' => 'eloquent',
                'model' => $this->app['config']->get('filament-access-control.user_model', FilamentUser::class),
            ],
        ], 'auth.providers');
    }

    /**
     * Merge passwords configuration.
     */
    protected function mergePasswordsConfig(): void
    {
        $this->mergeConfig([
            'filament' => [
                'provider' => 'filament_users',
                'email' => 'auth.emails.password',
                'table' => 'filament_password_resets',
                'expire' => 60,
            ],
        ], 'auth.passwords');
    }

    /**
     * Merge config from array.
     */
    protected function mergeConfig(array $config, string $key): void
    {
        $default = $this->app['config']->get($key, []);
        $this->app['config']->set($key, array_merge($config, $default));
    }
}
