<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\PermissionResource\Pages;

use Chiiya\FilamentAccessControl\Resources\PermissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
