<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BrandManagerInfoEmailWithButton extends Notification
{
    use Queueable;

    private $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->details['subject'])
            ->greeting('Merhaba, ' . $this->details['user']->name . ' ' . $this->details['user']->surname . '!')
            ->line($this->details['bodyText1'])
            ->action($this->details['buttonName'], $this->details['buttonUrl'])
            ->line($this->details['bodyText2']);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
