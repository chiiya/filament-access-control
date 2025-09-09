<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilamentUsers extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.user', FilamentUserResource::class);
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
