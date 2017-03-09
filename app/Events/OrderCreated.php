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

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $order;
    public $userId;
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
        $this->userId = Auth::id();
        $this->dateTime = new DateTime;
    }

    public function broadcastOn()
    {
        return new Channel('order-updates');
    }

    public function broadcastAs()
    {
        return 'order-created';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'status' => $this->order->status
        ];
    }

}
