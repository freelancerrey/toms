<?php

namespace App\Observers;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Auth;
use App\Note;
use DateTime;

class NoteObserver
{

    public function __construct(LogRepository $logRepository) {
        $this->logRepository = $logRepository;
    }

    public function created(Note $note)
    {

        $note = $note->toArray();

        $this->logRepository->insert([
            'order' => $note['order'],
            'user' => Auth::id(),
            'log' => "Added <#>Note</#> with ID <*>".$note['id']."</*>",
            'created_at' => new DateTime()
        ]);

    }

}
