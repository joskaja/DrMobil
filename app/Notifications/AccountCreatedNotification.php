<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class AccountCreatedNotification extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Vítejte na e-shopu Dr. Mobil')
            ->line(Lang::get('vítejte mezi námi :name.', ['name' => $this->user->full_name]))
            ->line('Váš účet na e-shopu Dr. Mobil je připraven k použití.')
            ->line(Lang::get('Můžete se k němu přihlásit pomocí e-mailové adresy :email.', ['email' => $this->user->email]))
            ->action('Začít nakupovat', url(route('home')))
            ->line('Děkujeme za registraci a těšíme se až Vám budeme moci pomoci s Vašimi objednávkami.');
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
