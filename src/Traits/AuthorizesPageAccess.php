<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Traits;

use Filament\Facades\Filament;

trait AuthorizesPageAccess
{
    public static function authorizePageAccess(): void
    {
        abort_unless(static::canView(), 403);
    }

    public static function canView(): bool
    {
        return Filament::auth()->user()->can(static::getPermissionName());
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canView() && static::$shouldRegisterNavigation;
    }

    protected static function getPermissionName(): string
    {
        return static::$permission;
    }
}
