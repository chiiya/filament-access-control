<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\PermissionRegistrar;

class EditFilamentUser extends EditRecord
{
    protected static string $resource = FilamentUserResource::class;

    public function afterCreate(): void
    {
        if (! $this->record instanceof FilamentUser) {
            return;
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
