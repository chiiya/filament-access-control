<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ResetPassword extends Component implements HasForms
{
    use InteractsWithForms;
    public ?string $email = '';
    public ?string $token = '';
    public ?string $password = '';
    public ?string $password_confirm = '';

    public function mount(string $token): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->email = request()->query('email', '');
        $this->token = $token;
        $this->form->fill();
    }

    public function submit()
    {
        $data = $this->form->getState();

        $credentials = [
            'token' => $this->token,
            'email' => $this->email,
            'password' => $data['password'],
        ];

        $response = Password::broker('filament')->reset(
            $credentials,
            function ($user, string $password): void {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            },
        );

        if ($response === Password::PASSWORD_RESET) {
            Notification::make()->title(__('passwords.reset'))->success()->send();

            return redirect()->route('filament.auth.login', [
                'email' => $this->email,
            ]);
        }

        throw ValidationException::withMessages([
            'password' => __($response),
        ]);
    }

    public function render(): View
    {
        return view('filament-access-control::password.reset')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament-access-control::default.pages.reset_password'),
            ]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('password')
                ->label(__('filament-access-control::default.fields.password'))
                ->validationAttribute(__('filament-access-control::default.fields.password'))
                ->password()
                ->helperText(config('filament-access-control.password_hint'))
                ->required()
                ->rules(config('filament-access-control.password_rules')),
            TextInput::make('password_confirm')
                ->label(__('filament-access-control::default.fields.password_confirm'))
                ->validationAttribute(__('filament-access-control::default.fields.password_confirm'))
                ->required()
                ->password()
                ->same('password'),
        ];
    }
}
