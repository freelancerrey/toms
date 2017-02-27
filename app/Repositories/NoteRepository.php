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
