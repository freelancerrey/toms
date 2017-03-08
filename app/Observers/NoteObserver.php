<?php

namespace App\Observers;

use App\Jobs\LogCreatedNote;
use Illuminate\Support\Facades\Auth;
use App\Note;
use DateTime;

class NoteObserver
{

    private $userId;

    public function __construct()
    {
        $this->userId = Auth::id();
    }

    public function created(Note $note)
    {
        $logJob = (new LogCreatedNote($note, $this->userId, new DateTime))->onQueue('logs');
        dispatch($logJob);
    }

}
