<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Support\Facades\Auth;
use App\Order;
use DateTime;

class OrderUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $order;
    public $user;
    public $dateTime;

    public $broadcastQueue = 'broadcasts';

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->user = Auth::user();
        $this->dateTime = new DateTime;
    }

    public function broadcastOn()
    {
        return new Channel('order-updates');
    }

    public function broadcastAs()
    {
        return 'order-updated';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'old_status' => $this->order->getOriginal('status'),
            'new_status' => $this->order->status,
            'user' => $this->user->name
        ];
    }

}
