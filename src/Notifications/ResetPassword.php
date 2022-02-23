<?php

namespace Chiiya\FilamentAccessControl\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as LaravelResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends LaravelResetPassword
{
    /**
     * Get the reset URL for the given notifiable.
     *
     * @param mixed $notifiable
     */
    protected function resetUrl($notifiable): string
    {
        return url(route('filament.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param string $url
     */
    protected function buildMailMessage($url): MailMessage
    {
        $host = parse_url(url()->to('/'))['host'];

        return (new MailMessage())
            ->subject(__('filament-access-control::default.notifications.password_reset.title', [
                'host' => $host,
            ]))
            ->greeting(__('filament-access-control::default.notifications.password_reset.title', [
                'host' => $host,
            ]))
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(__('Reset Password'), $url)
            ->line(__('This password reset link will expire in :count minutes.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]))
            ->line(__('If you did not request a password reset, no further action is required.'));
    }
}
