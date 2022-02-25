<?php

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
class ForgotPassword extends Component implements HasForms
{
    use CanNotify;
    use InteractsWithForms;

    public ?string $email = '';

    public function mount()
    {
        if (Filament::auth()->check()) {
            return redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function send(): void
    {
        $data = $this->form->getState();
        $response = Password::broker('filament')->sendResetLink([
            'email' => $data['email'],
        ]);

        if ($response === Password::RESET_LINK_SENT) {
            $this->notify('success', __('passwords.sent'));
        } else {
            $this->addError('email', __($response));
        }
    }

    public function render(): View
    {
        return view('filament-access-control::password.request')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-access-control::default.pages.reset_password'),
            ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(__('filament-access-control::default.fields.email'))
                ->validationAttribute(__('filament-access-control::default.fields.email'))
                ->email()
                ->required()
                ->autocomplete(),
        ];
    }
}
