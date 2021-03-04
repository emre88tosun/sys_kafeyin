<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPassEmail extends Notification
{
    use Queueable;

    public $token;

    public static $createUrlCallback;

    public static $toMailCallback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }

        return $this->buildMailMessage($url, $notifiable);
    }

    protected function buildMailMessage($url, $notifiable)
    {
        return (new MailMessage)
            ->subject("Şifre yenileme bağlantısı")
            ->greeting('Merhaba, '.$notifiable->name.' '.$notifiable->surname.'!')
            ->line("Şifre yenileme bağlantısı talebiniz üzerine bu e-postayı size gönderdik.")
            ->action("Şifremi Yenile", $url)
            ->line(Lang::get('Bu şifre yenileme bağlantısı :count dakika için geçerlidir.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line("Eğer şifre yenileme bağlantısı talebiniz olmadıysa bu e-postayı görmezden gelebilirsiniz.");
    }

    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }

    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
