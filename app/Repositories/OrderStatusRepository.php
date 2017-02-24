<?php
namespace App\Repositories;

use App\OrderStatus;

class OrderStatusRepository
{

    public function getAllActive()
    {

        return OrderStatus::join(
            'status_categories',
            'order_statuses.category',
            '=',
            'status_categories.id'
        )
        ->select(
            'order_statuses.*',
            'status_categories.category'
        )
        ->where('order_statuses.is_active', true)
        ->orderBy('order_statuses.id')
        ->get()
        ->toArray();

    }

    public function getAllForFilter()
    {

        $orderStatuses = OrderStatus::join(
            'status_categories',
            'order_statuses.category',
            '=',
            'status_categories.id'
        )
        ->select(
            'order_statuses.*',
            'order_statuses.category as cat_id',
            'status_categories.category'
        )
        ->orderBy('order_statuses.id')
        ->get()
        ->toArray();

        $arrangedStatuses = [];

        foreach ($orderStatuses as $status) {
            $arrangedStatuses[$status['category']][$status['id']] = $status['status'];
        }

        return $arrangedStatuses;

    }

}
