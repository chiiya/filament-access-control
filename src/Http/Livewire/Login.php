<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Exceptions\InvalidUserModelException;
use Chiiya\FilamentAccessControl\Exceptions\UserNotFoundException;
use Chiiya\FilamentAccessControl\Notifications\TwoFactorCode;
use Chiiya\FilamentAccessControl\Services\AuthService;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Livewire\Auth\Login as FilamentLogin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class Login extends FilamentLogin
{
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
                'email' => __('filament::login.messages.throttled', [
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
                'email' => $exception->getMessage(),
            ]);
        }

        if (Feature::enabled(Feature::TWO_FACTOR)) {
            if (! $user->hasTwoFactorCode() || $user->twoFactorCodeIsExpired()) {
                $user->notify(new TwoFactorCode);
            }

            session()->put('filament.id', $user->getKey());
            session()->put('filament.remember', $data['remember']);

            return redirect()->route('filament.account.two-factor');
        }

        $auth->login($user, $data['remember']);

        return redirect()->intended(Filament::getUrl());
    }

    public function render(): View
    {
        return view('filament-access-control::login')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament::login.title'),
            ]);
    }
}
