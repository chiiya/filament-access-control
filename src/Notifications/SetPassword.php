<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $token,
    ) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return $this->buildMailMessage($this->resetUrl($notifiable));
    }

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
     * Get the set password notification mail message for the given URL.
     */
    protected function buildMailMessage(string $url): MailMessage
    {
        $host = parse_url(url()->to('/'))['host'];

        return (new MailMessage)
            ->subject(__('filament-access-control::default.notifications.password_set.title', [
                'host' => $host,
            ]))
            ->markdown('filament-access-control::emails.password-set', [
                'url' => $url,
                'host' => $host,
            ]);
    }
}
