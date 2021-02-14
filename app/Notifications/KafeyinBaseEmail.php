<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KafeyinBaseEmail extends Notification
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
                    ->greeting('Merhaba, '.$this->details['user']->name.' '.$this->details['user']->surname.'!')
                    ->line($this->details['bodyText']);
    }


    public function toArray($notifiable)
    {
        return [

        ];
    }
}
