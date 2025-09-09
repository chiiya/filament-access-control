<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Services;

use Chiiya\FilamentAccessControl\Contracts\AccessControlUser;
use Exception;
use Filament\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Password;

class AuthService
{
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
}
