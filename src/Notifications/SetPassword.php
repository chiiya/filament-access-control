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
        protected string $url,
        protected string $requestUrl,
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
    public function toMail(): MailMessage
    {
        return $this->buildMailMessage($this->url, $this->requestUrl);
    }

    /**
     * Get the set password notification mail message for the given URL.
     */
    protected function buildMailMessage(string $url, string $requestUrl): MailMessage
    {
        $host = parse_url(url()->to('/'))['host'];

        return (new MailMessage)
            ->subject(__('filament-access-control::default.notifications.password_set.title', [
                'host' => $host,
            ]))
            ->markdown('filament-access-control::emails.password-set', [
                'url' => $url,
                'requestUrl' => $requestUrl,
                'host' => $host,
            ]);
    }
}
