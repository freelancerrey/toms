<?php
namespace App\Repositories;

use App\OrderStatus;

class OrderStatusRepository
{

    public function getAllForView()
    {

        return OrderStatus::leftJoin(
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

}
