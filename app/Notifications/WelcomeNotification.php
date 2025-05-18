<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $userName)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Welcome to Our Platform')
            ->greeting('Hello ' . $this->userName . '!')
            ->line('Thank you for registering. We’re glad to have you with us.')
            ->line('Let us know if you have any questions.')
            ->salutation('Warm regards, The Team');
    }
}
