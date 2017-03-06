<?php
namespace App\Repositories;

use App\Note;
use DB;

class NoteRepository
{

    public function save(Note $note)
    {

        $saved = false;

        DB::transaction(function () use ($note, &$saved) {

            $saved = $note->save();

        });

        if (!$saved) {
            abort(500, "Something went wrong!! Can't save Note");
        }

    }

    public function getForOrder($orderId)
    {
        return Note::join(
                'users',
                'notes.user',
                '=',
                'users.id'
            )->select(
                'notes.*',
                'users.name as author'
            )->where('notes.order', '=', $orderId)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function getMatch($searchKey){
        return Note::whereRaw(
            "MATCH(note) AGAINST( ? IN BOOLEAN MODE)",
            [$searchKey.'*']
        )
        ->select('order')
        ->groupby('order')
        ->get()
        ->toArray();
    }

}
