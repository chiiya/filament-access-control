<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListFilamentUsers extends ListRecords
{
    protected static string $resource = FilamentUserResource::class;

    public function extendUsers(Collection $users): void
    {
        $users->each->extend();

        Notification::make()->title(
            __('filament-access-control::default.messages.accounts_extended'),
        )->success()->send();
    }
}
