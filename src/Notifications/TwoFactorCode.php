<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCode extends Notification implements ShouldQueue
{
    use Queueable;

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
        $code = $this->generateTwoFactorCode();
        $notifiable->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(5),
        ]);

        return $this->buildMailMessage($code);
    }

    /**
     * Generate random 6-digit code.
     */
    protected function generateTwoFactorCode(): string
    {
        return implode('', array_map(fn () => random_int(0, 9), range(1, 6)));
    }

    /**
     * Get the two-factor code notification mail message for the given code.
     */
    protected function buildMailMessage(string $code): MailMessage
    {
        $host = parse_url(url()->to('/'))['host'];

        return (new MailMessage)
            ->subject(__('filament-access-control::default.notifications.two_factor.title', [
                'host' => $host,
            ]))
            ->markdown('filament-access-control::emails.two-factor', [
                'code' => $code,
                'host' => $host,
            ]);
    }
}
