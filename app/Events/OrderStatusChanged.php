<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var $order Order
     */
    public $order;

    /**
     * Event that's fired when order status changes
     * OrderStatusChanged constructor.
     * @param $order Order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('orders');
    }
}
