<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFilamentUser extends ViewRecord
{
    protected static string $resource = FilamentUserResource::class;
}
