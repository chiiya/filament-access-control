<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\RoleResource\Pages;

use Chiiya\FilamentAccessControl\Resources\RoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;

class EditRole extends EditRecord
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.role', RoleResource::class);
    }

    public function afterSave(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
