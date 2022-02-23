<?php

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Filament\Http\Livewire\Auth\Login as FilamentLogin;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Contracts\View\View;

class Login extends FilamentLogin
{
    use CanNotify;

    public function mount(): void
    {
        parent::mount();

        if ($email = request()->input('email')) {
            $this->form->fill([
                'email' => $email,
            ]);
        }
    }

    public function render(): View
    {
        return view('filament-access-control::login')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament::login.title'),
            ]);
    }
}
