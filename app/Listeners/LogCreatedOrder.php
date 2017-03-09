<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\LogService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCreatedOrder implements ShouldQueue
{

    private $logService;

    public $queue = 'logs';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $this->logService->createForNewOrder($event->order, $event->userId, $event->dateTime);
    }
}
