<?php

namespace App\Observers;

use App\Jobs\LogCreatedOrder;
use App\Jobs\LogUpdatedOrder;
use Illuminate\Support\Facades\Auth;
use App\Order;
use DateTime;

class OrderObserver
{

    private $userId;

    public function __construct()
    {
        $this->userId = Auth::id();
    }

    public function created(Order $order)
    {
        $logJob = (new LogCreatedOrder($order, $this->userId, new DateTime))->onQueue('logs');
        dispatch($logJob);
    }

    public function updated(Order $order)
    {
        $logJob = (new LogUpdatedOrder($order, $this->userId, new DateTime))->onQueue('logs');
        dispatch($logJob);
    }

}
