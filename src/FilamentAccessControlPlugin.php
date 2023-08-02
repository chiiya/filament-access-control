<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Http\Livewire\Login;
use Chiiya\FilamentAccessControl\Http\Middleware\EnsureAccountIsNotExpired;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Chiiya\FilamentAccessControl\Resources\RoleResource;
use Filament\Contracts\Plugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Panel;

class FilamentAccessControlPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        return filament(app(static::class)->getId());
    }

    public function getId(): string
    {
        return 'filament-access-control';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->authGuard('filament')
            ->login(Login::class)
            ->authPasswordBroker('filament')
            ->passwordReset()
            ->authMiddleware([
                Authenticate::class,
                ...(Feature::enabled(Feature::ACCOUNT_EXPIRY) ? [EnsureAccountIsNotExpired::class] : []),
            ])
            ->resources([FilamentUserResource::class, PermissionResource::class, RoleResource::class]);
    }

    public function boot(Panel $panel): void {}
}
