<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class AccountExpired extends Component
{
    public function render(): View
    {
        return view('filament-access-control::expired')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament-access-control::default.pages.account_expired'),
            ]);
    }
}
