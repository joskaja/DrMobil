<?php

namespace App\Listeners;

use App\Mail\Verification;
use App\Events\Registered;
use App\Notifications\AccountCreatedNotification;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendEmailVerificationNotification
{
    /**
     * Listener that's fired when new user registered and sends e-mail to user
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if (!empty($event->user)) {
            $user = $event->user;
            Notification::send($user, new AccountCreatedNotification($user));

        }
    }
}
