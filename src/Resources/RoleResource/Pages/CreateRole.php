<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\RoleResource\Pages;

use Chiiya\FilamentAccessControl\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\PermissionRegistrar;

class CreateRole extends CreateRecord
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.role', RoleResource::class);
    }

    public function afterCreate(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['guard_name'] = 'filament';

        return $data;
    }
}
