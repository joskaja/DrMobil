<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Oznámení o změně hesla'))
            ->line(Lang::get('Tento e-mail přišel jako reakce o zažádání o změnu hesla pro tuto e-mailovou adresu.'))
            ->action(Lang::get('Obnovit heslo'), $url)
            ->line(Lang::get('Tento odkaz na změnu hesla vyprší za :count minut.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Pokud jste o změnu hesla nežádal/a, není nutné podnikat další akce.'));
    }
}
