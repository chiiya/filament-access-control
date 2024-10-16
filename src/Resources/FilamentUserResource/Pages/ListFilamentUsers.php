<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages;

use Chiiya\FilamentAccessControl\Resources\FilamentUserResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;

class ListFilamentUsers extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.user', FilamentUserResource::class);
    }

    public function extendUsers(Collection $users): void
    {
        $users->each->extend();

        $message = $users->count() === 1
            ? __('filament-access-control::default.messages.account_extended')
            : __('filament-access-control::default.messages.accounts_extended');

        Notification::make()
            ->title($message)
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
