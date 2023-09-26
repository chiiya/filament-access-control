<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl;

use Chiiya\FilamentAccessControl\Commands\CreateFilamentUser;
use Chiiya\FilamentAccessControl\Commands\Install;
use Chiiya\FilamentAccessControl\Http\Livewire\AccountExpired;
use Chiiya\FilamentAccessControl\Http\Livewire\Login;
use Chiiya\FilamentAccessControl\Http\Livewire\TwoFactorChallenge;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Chiiya\FilamentAccessControl\Policies\FilamentUserPolicy;
use Chiiya\FilamentAccessControl\Policies\PermissionPolicy;
use Chiiya\FilamentAccessControl\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentAccessControlServiceProvider extends PackageServiceProvider
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

        $this->registerComponent(Login::class);
        $this->registerComponent(AccountExpired::class);
        $this->registerComponent(TwoFactorChallenge::class);
        Gate::policy(config('filament-access-control.user_model'), FilamentUserPolicy::class);
        Gate::policy(config('permission.models.role'), RolePolicy::class);
        Gate::policy(config('permission.models.permission'), PermissionPolicy::class);
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

    protected function registerComponent(string $component): void
    {
        $name = app(ComponentRegistry::class)->getName($component);
        Livewire::component($name, $component);
    }
}
