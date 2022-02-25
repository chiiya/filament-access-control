<?php

use Chiiya\FilamentAccessControl\Http\Livewire\AccountExpired;
use Chiiya\FilamentAccessControl\Http\Livewire\ForgotPassword;
use Chiiya\FilamentAccessControl\Http\Livewire\ResetPassword;
use Chiiya\FilamentAccessControl\Http\Livewire\TwoFactorChallenge;

Route::domain(config('filament.domain'))
    ->middleware(config('filament.middleware.base'))
    ->prefix(config('filament.path'))
    ->name('filament.')
    ->group(function (): void {
        Route::get('/password/request', ForgotPassword::class)->name('password.request');
        Route::get('/password/reset/{token}', ResetPassword::class)->name('password.reset');
        Route::get('/auth/expired', AccountExpired::class)->name('account.expired');
        Route::get('/auth/two-factor', TwoFactorChallenge::class)->name('account.two-factor');
    });
