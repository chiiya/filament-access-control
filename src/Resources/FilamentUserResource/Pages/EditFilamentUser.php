<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Arr;
use Spatie\Permission\PermissionRegistrar;

class EditFilamentUser extends EditRecord
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.user', FilamentUserResource::class);
    }

    public function afterSave(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return Arr::except($data, ['role']);
    }

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
