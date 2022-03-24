<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Services;

use Chiiya\FilamentAccessControl\Exceptions\InvalidCodeException;
use Chiiya\FilamentAccessControl\Exceptions\UserNotFoundException;
use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Chiiya\FilamentAccessControl\Notifications\TwoFactorCode;
use Filament\Facades\Filament;

class AuthService
{
    /**
     * Validate user credentials.
     *
     * @throws UserNotFoundException
     */
    public function validateCredentials(array $credentials): FilamentUser
    {
        $user = FilamentUser::query()->where('email', '=', $credentials['email'])->first();

        if ($user === null) {
            throw new UserNotFoundException(__('filament::login.messages.failed'));
        }

        if (! Filament::auth()->validate($credentials)) {
            throw new UserNotFoundException(__('filament::login.messages.failed'));
        }

        return $user;
    }

    /**
     * Log in the given filament user.
     */
    public function login(FilamentUser $user, bool $remember = false): void
    {
        Filament::auth()->login($user, $remember);
    }

    /**
     * Determine if there is a challenged user in the current session.
     */
    public function hasChallengedUser(): bool
    {
        return session()->has('filament.id');
    }

    /**
     * Get the user that is attempting the two factor challenge.
     *
     * @throws UserNotFoundException
     */
    public function getChallengedUser(): FilamentUser
    {
        if (! $this->hasChallengedUser()) {
            throw new UserNotFoundException(__('filament-access-control::default.messages.invalid_user'));
        }

        $user = FilamentUser::query()->where('id', '=', session()->get('filament.id'))->first();

        if (! $user) {
            throw new UserNotFoundException(__('filament-access-control::default.messages.invalid_user'));
        }

        return $user;
    }

    /**
     * Verify the two-factor authentication code.
     *
     * @throws InvalidCodeException
     * @throws UserNotFoundException
     */
    public function performTwoFactorChallenge(string $code): void
    {
        $user = $this->getChallengedUser();

        if ($user->twoFactorCodeIsExpired()) {
            $user->notify(new TwoFactorCode);

            throw new InvalidCodeException(__('filament-access-control::default.messages.code_expired'));
        }

        if ($user->two_factor_code !== $code) {
            throw new InvalidCodeException(__('filament-access-control::default.messages.invalid_code'));
        }

        $this->login($user, session()->get('filament.remember', false));
    }
}
