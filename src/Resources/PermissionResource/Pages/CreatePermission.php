<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\PermissionResource\Pages;

use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.permission', PermissionResource::class);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['guard_name'] = 'filament';

        return $data;
    }
}
