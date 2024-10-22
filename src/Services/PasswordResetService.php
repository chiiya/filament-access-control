<?php

namespace Chiiya\FilamentAccessControl\Services;

use Chiiya\FilamentAccessControl\Models\FilamentUser;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Password;
use Filament\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use Filament\Notifications\Notification;
use Exception;

class PasswordResetService
{
    public function sendResetLink(FilamentUser $user)
    {
        try {
            $token = Password::broker('filament')->createToken($user);

            // Create the notification and set the URL
            $notification = new ResetPasswordNotification($token);
            $notification->url = Filament::getResetPasswordUrl($token, $user);

            // Send the notification
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
