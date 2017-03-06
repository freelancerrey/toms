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

}
