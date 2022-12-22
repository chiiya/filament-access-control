<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
class ForgotPassword extends Component implements HasForms
{
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
            Notification::make()->title(__('passwords.sent'))->success()->send();
        } else {
            throw ValidationException::withMessages([
                'email' => __($response),
            ]);
        }
    }

    public function render(): View
    {
        return view('filament-access-control::password.request')
            ->layout('filament::components.layouts.card', [
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
