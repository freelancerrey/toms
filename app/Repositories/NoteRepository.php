<?php
namespace App\Repositories;

use App\Note;
use DB;

class NoteRepository
{

    public function save(Note $note)
    {

        DB::transaction(function () use ($note) {

            $note->save();

        });

    }

}
