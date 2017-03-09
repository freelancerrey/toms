<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use App\Services\LogService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUpdatedOrder implements ShouldQueue
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
    public function handle(OrderUpdated $event)
    {
        $this->logService->createForUpdatedOrder($event->order, $this->user->id, $event->dateTime);
    }
}
