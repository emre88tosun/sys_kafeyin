<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('E-posta adresi doğrulama')
                ->line('E-posta adresinizi doğrulamak için lütfen aşağıdaki butona tıklayınız.')
                ->action('Doğrula', $url)
                ->line('Eğer bir hesap oluşturma talebiniz olmadıysa, bu e-postayı göz ardı edebilirsiniz.');
        });

        $this->registerPolicies();

        //
    }
}
