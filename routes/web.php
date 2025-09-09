<?php declare(strict_types=1);

use Chiiya\FilamentAccessControl\Http\Livewire\AccountExpired;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

Route::name('filament.')->group(function (): void {
    foreach (Filament::getPanels() as $panel) {
        $domains = $panel->getDomains();

        foreach ((empty($domains) ? [null] : $domains) as $domain) {
            Route::domain($domain)
                ->middleware($panel->getMiddleware())
                ->name($panel->getId().'.')
                ->prefix($panel->getPath())
                ->group(function (): void {
                    Route::get('/auth/expired', AccountExpired::class)->name('account.expired');
                });
        }
    }
});
