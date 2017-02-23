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

    public function getList(array $data){
        return Order::join(
            'payments',
            'orders.payment',
            '=',
            'payments.id'
        )->leftJoin(
            'order_types',
            'orders.type',
            '=',
            'order_types.id'
        )->join(
            'order_statuses',
            'orders.status',
            '=',
            'order_statuses.id'
        )->join(
            'status_categories',
            'order_statuses.category',
            '=',
            'status_categories.id'
        )->select(
            'orders.id',
            'orders.name',
            'orders.clicks',
            'orders.date_submitted',
            'orders.priority',
            'payments.name as payment_name',
            'payments.date as payment_date',
            'order_types.type',
            'status_categories.category as status_category',
            'order_statuses.status'
        )->paginate(10);
    }

}
