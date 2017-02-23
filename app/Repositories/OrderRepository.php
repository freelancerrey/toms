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

        /*

        $defaultSorter = config('default_orders_list_sort');
        $sortingMap = config('custom.orders_list_sort_map');

        $sorter = $defaultSorter;

        if (array_key_exists('sort', $data)) {

            $sortIndex = $data['sort']['index'];

            $sorter = [
                [$sortingMap[$sortIndex][0] => $data['sort']['direction']]
            ];

            if (is_null($sortingMap[$sortIndex][1])) {
                foreach ($defaultSorter as $column => $direction) {
                    $sorter[$column] = $direction;
                }
            } else {
                foreach ($sortingMap[$sortIndex][1] as $column => $direction) {
                    $sorter[$column] = $direction;
                }
            }

        }

        */

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
        )->paginate(config('custom.orders_list_per_page'));
    }

}
