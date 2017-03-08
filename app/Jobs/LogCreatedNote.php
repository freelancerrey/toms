<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\LogService;
use App\Note;
use DateTime;

class LogCreatedNote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $note;
    private $userId;
    private $dateTime;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Note $note, $userId, DateTime $dateTime)
    {
        $this->note = $note;
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
        $logService->createForNote($this->note, $this->userId, $this->dateTime);
    }
}
