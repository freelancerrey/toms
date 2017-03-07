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
            'users',
            'logs.user',
            '=',
            'users.id'
        )
        ->where('logs.order', '=', $orderId)
        ->select(
            'logs.id',
            'logs.created_at as date',
            'users.name',
            'logs.log'
        )
        ->orderBy('id','desck')
        ->get()
        ->toArray();

    }

}
