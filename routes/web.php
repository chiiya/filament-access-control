<?php

use Chiiya\FilamentAccessControl\Http\Livewire\AccountExpired;
use Chiiya\FilamentAccessControl\Http\Livewire\TwoFactorChallenge;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

Route::name('filament.')->group(function () {
    foreach (Filament::getPanels() as $panel) {
        Route::domain($panel->getDomain())
            ->middleware($panel->getMiddleware())
            ->name($panel->getId() . '.')
            ->prefix($panel->getPath())
            ->group(function () use ($panel) {
                Route::get('/auth/expired', AccountExpired::class)->name('account.expired');
                Route::get('/auth/two-factor', TwoFactorChallenge::class)->name('account.two-factor');
            });
    }
});
