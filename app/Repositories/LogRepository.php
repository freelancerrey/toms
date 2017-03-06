<?php
namespace App\Repositories;

use App\Log;
use DB;

class LogRepository
{

    public function insert(Array $logs)
    {

        $inserted = false;

        DB::transaction(function () use ($logs, &$inserted) {

            $inserted = Log::insert($logs);

        });

        if (!$inserted) {
            abort(500, "Something went wrong!! Can't insert Logs");
        }

    }

    public function getAllByOrder($orderId)
    {

        return Log::join(
            'Users',
            'Logs.user',
            '=',
            'Users.id'
        )
        ->where('Logs.order', '=', $orderId)
        ->select(
            'Logs.id',
            'Logs.created_at as date',
            'Users.name',
            'Logs.log'
        )
        ->orderBy('id','desck')
        ->get()
        ->toArray();

    }

}
