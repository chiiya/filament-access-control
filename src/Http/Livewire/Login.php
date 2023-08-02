<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Exceptions\InvalidUserModelException;
use Chiiya\FilamentAccessControl\Exceptions\UserNotFoundException;
use Chiiya\FilamentAccessControl\Notifications\TwoFactorCode;
use Chiiya\FilamentAccessControl\Services\AuthService;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Pages\Auth\Login as FilamentLogin;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class Login extends FilamentLogin
{
    protected static string $view = 'filament-access-control::login';

    public function mount(): void
    {
        parent::mount();

        if ($email = request()->input('email')) {
            $this->form->fill([
                'email' => $email,
            ]);
        }
    }

    /**
     * @throws InvalidUserModelException
     */
    public function login(AuthService $auth)
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'data.email' => __('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $data = $this->form->getState();

        try {
            $user = $auth->validateCredentials(Arr::only($data, ['email', 'password']));
        } catch (UserNotFoundException $exception) {
            throw ValidationException::withMessages([
                'data.email' => $exception->getMessage(),
            ]);
        }

        if (Feature::enabled(Feature::TWO_FACTOR)) {
            if (! $user->hasTwoFactorCode() || $user->twoFactorCodeIsExpired()) {
                $user->notify(new TwoFactorCode);
            }

            session()->put('filament.id', $user->getKey());
            session()->put('filament.remember', $data['remember']);

            $panel ??= Filament::getCurrentPanel()->getId();

            return redirect()->route("filament.{$panel}.account.two-factor");
        }

        $auth->login($user, $data['remember']);

        return redirect()->intended(Filament::getUrl());
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('login')
            ->label(__('filament-panels::pages/auth/login.form.actions.authenticate.label'))
            ->submit('login');
    }
}
