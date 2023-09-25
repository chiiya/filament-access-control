<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\PermissionResource\Pages;

use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.permission', PermissionResource::class);
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
