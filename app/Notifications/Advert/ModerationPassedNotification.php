<?php
declare(strict_types=1);

namespace App\Notifications\Advert;

use App\Models\Adverts\Advert\Advert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class ModerationPassedNotification extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $advert;

    public function __construct(Advert $advert)
    {
        $this->advert = $advert;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Moderation is passed')
            ->greeting('Hello!')
            ->line('Your advert successfully passed a moderation.')
            ->action('View Advert', route('adverts.show', $this->advert))
            ->line('Thank you for using our application!');
    }
}
