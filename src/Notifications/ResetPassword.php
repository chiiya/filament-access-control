<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as LaravelResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends LaravelResetPassword
{
    /**
     * Get the reset URL for the given notifiable.
     */
    protected function resetUrl(mixed $notifiable): string
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

        return (new MailMessage)
            ->subject(__('filament-access-control::default.notifications.password_reset.title', [
                'host' => $host,
            ]))
            ->markdown('filament-access-control::emails.password-reset', [
                'url' => $url,
                'host' => $host,
            ]);
    }
}
