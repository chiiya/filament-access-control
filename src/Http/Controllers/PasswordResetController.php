<?php

namespace Chiiya\FilamentAccessControl\Http\Controllers;

use Exception;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Filament\Notifications\Auth\ResetPassword as ResetPasswordNotification;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\CanResetPassword;

class PasswordResetController
{
    public function sendResetLink(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email',
        ]);

        // Attempt to send the reset link
        $response = Password::sendResetLink($request->only('email'), function (CanResetPassword $user, string $token): void {
            if (! method_exists($user, 'notify')) {
                $userClass = $user::class;

                throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
            }

            $notification = new ResetPasswordNotification($token);
            $notification->url = Filament::getResetPasswordUrl($token, $user);

            $user->notify($notification);
        });

        // Check the response status
        if ($response === Password::RESET_LINK_SENT) {
            Notification::make()
                ->title(__('Password reset link sent!'))
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title(__('Failed to send password reset link.'))
                ->danger()
                ->send();
        }
    }
}
