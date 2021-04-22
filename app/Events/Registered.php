<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class Registered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     *
     * @var $user User
     */
    public $user;

    /**
     * Event that's fired when new user is registered
     * Registered constructor.
     * @param $user User
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return PrivateChannel
     */
    function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('users');
    }
}
