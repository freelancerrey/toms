<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\LogService;
use App\Order;
use DateTime;

class LogUpdatedOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    private $userId;
    private $dateTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order, $userId, DateTime $dateTime)
    {
        $this->order = $order;
        $this->userId = $userId;
        $this->dateTime = $dateTime;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(LogService $logService)
    {
        $logService->createForUpdatedOrder($this->order, $this->userId, $this->dateTime);
    }
}
