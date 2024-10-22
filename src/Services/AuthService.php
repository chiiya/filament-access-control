<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Services;

use Chiiya\FilamentAccessControl\Contracts\AccessControlUser;
use Chiiya\FilamentAccessControl\Exceptions\InvalidCodeException;
use Chiiya\FilamentAccessControl\Exceptions\InvalidUserModelException;
use Chiiya\FilamentAccessControl\Exceptions\UserNotFoundException;
use Exception;
use Filament\Facades\Filament;
use Filament\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Password;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthService
{
    /**
     * Validate user credentials.
     *
     * @throws UserNotFoundException
     * @throws InvalidUserModelException
     */
    public function validateCredentials(array $credentials): AccessControlUser
    {
        $user = $this->getUserModel()->newQuery()->where('email', '=', $credentials['email'])->first();

        if ($user === null) {
            throw new UserNotFoundException(__('filament-panels::pages/auth/login.messages.failed'));
        }

        if (! $user instanceof AccessControlUser) {
            throw InvalidUserModelException::create($this->getUserModel());
        }

        if (! Filament::auth()->validate($credentials)) {
            throw new UserNotFoundException(__('filament-panels::pages/auth/login.messages.failed'));
        }

        return $user;
    }

    /**
     * Log in the given filament user.
     */
    public function login(Authenticatable $user, bool $remember = false): void
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
     * @throws InvalidUserModelException
     * @throws UserNotFoundException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getChallengedUser(): AccessControlUser
    {
        if (! $this->hasChallengedUser()) {
            throw new UserNotFoundException(__('filament-access-control::default.messages.invalid_user'));
        }

        $user = $this->getUserModel()->newQuery()->where('id', '=', session()->get('filament.id'))->first();

        if (! $user) {
            throw new UserNotFoundException(__('filament-access-control::default.messages.invalid_user'));
        }

        if (! $user instanceof AccessControlUser) {
            throw InvalidUserModelException::create($this->getUserModel());
        }

        return $user;
    }

    /**
     * Verify the two-factor authentication code.
     *
     * @throws ContainerExceptionInterface
     * @throws InvalidCodeException
     * @throws InvalidUserModelException
     * @throws NotFoundExceptionInterface
     * @throws UserNotFoundException
     */
    public function performTwoFactorChallenge(string $code): void
    {
        $user = $this->getChallengedUser();

        if ($user->twoFactorCodeIsExpired()) {
            $user->sendTwoFactorCodeNotification();

            throw new InvalidCodeException(__('filament-access-control::default.messages.code_expired'));
        }

        if ($user->getTwoFactorCode() !== $code) {
            throw new InvalidCodeException(__('filament-access-control::default.messages.invalid_code'));
        }

        $this->login($user, session()->get('filament.remember', false));
    }

    /**
     * Manually send a password reset link to the user.
     */
    public function sendResetLink(AccessControlUser $user): void
    {
        try {
            $token = Password::broker('filament')->createToken($user);
            $notification = new ResetPasswordNotification($token);
            $notification->url = Filament::getResetPasswordUrl($token, $user);
            $user->notify($notification);

            Notification::make()
                ->title(__('filament-access-control::default.messages.password_reset_link_sent'))
                ->success()
                ->send();
        } catch (Exception $e) {
            Notification::make()
                ->title($e->getMessage())
                ->danger()
                ->send();
        }
    }

    private function getUserModel(): Model
    {
        /** @var class-string<Model> $model */
        $model = config('filament-access-control.user_model');

        return new $model;
    }
}
