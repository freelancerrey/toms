<?php
namespace App\Repositories;

use App\Order;
use DB;

class OrderRepository
{

    public function save(Order $order)
    {

        DB::transaction(function () use ($order) {

            $order->save();

        });

    }

}
