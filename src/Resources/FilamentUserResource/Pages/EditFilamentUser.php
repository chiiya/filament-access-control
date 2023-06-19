<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;

class EditFilamentUser extends EditRecord
{
    protected static string $resource = FilamentUserResource::class;

    public function afterSave(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
