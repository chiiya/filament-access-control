<?php

namespace Chiiya\FilamentAccessControl\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $token
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

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
            ->subject(__('filament-access-control::default.notifications.password_set.title', [
                'host' => $host,
            ]))
            ->greeting(__('filament-access-control::default.notifications.password_set.title', [
                'host' => $host,
            ]))
            ->line(__('filament-access-control::default.notifications.password_set.message', [
                'host' => $host,
            ]))
            ->action(__('filament-access-control::default.notifications.password_set.button'), $url)
            ->line(__('This password reset link will expire in :count minutes.', [
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire'),
            ]));
    }
}
