<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Mail\OrderStatus;
use App\Notifications\OrderStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendOrderStatusEmail
{
    /**
     * Listener that's fired when order status changes and sends email to user
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
     * @param OrderStatusChanged $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        if (!empty($event->order)) {
            $order = $event->order;
            Notification::send($order->user, new OrderStatusNotification($order));

        }
    }
}
