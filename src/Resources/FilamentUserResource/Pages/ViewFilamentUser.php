<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFilamentUser extends ViewRecord
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.user', FilamentUserResource::class);
    }
}
