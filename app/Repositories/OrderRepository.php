<?php
namespace App\Repositories;

use App\Order;
use DB;

class OrderRepository
{

    public function save(Order $order)
    {

        $saved = false;

        DB::transaction(function () use ($order, &$saved) {

            $saved = $order->save();

        });

        if (!$saved) {
            abort(500, "Something went wrong!! Can't save Order");
        }

    }

    public function getById($id)
    {

        return Order::findOrFail($id);

    }

    public function getRecord($id)
    {

        return Order::join(
            'payments',
            'orders.payment',
            '=',
            'payments.id'
        )->select(
            'orders.id as id',
            'payments.id as payment-id',
            'payments.reference as payment-reference',
            'payments.gateway as payment-gateway',
            'payments.name as payment-name',
            'payments.email as payment-email',
            'payments.amount as payment-amount',
            'payments.date as payment-date',
            'orders.put_on_top as order-put_on_top',
            'orders.entry as order-entry',
            'orders.type as order-type',
            'orders.name as order-name',
            'orders.email as order-email',
            'orders.paypal_name as order-paypal_name',
            'orders.clicks as order-clicks',
            'orders.date_submitted as order-date_submitted',
            'orders.url as order-url',
            'orders.stats as order-stats',
            'orders.in_rotator as order-in_rotator',
            'orders.clicks_sent as order-clicks_sent',
            'orders.optins as order-optins',
            'orders.followup_sent as order-followup_sent',
            'orders.screenshot as order-screenshot',
            'orders.priority as order-priority',
            'orders.status as order-status'
        )->where(
            'orders.id', '=', $id
        )->first();

    }

    public function getList(array $data, array $noteMatches = []){

        $defaultSorter = config('custom.default_orders_list_sort');
        $sortingMap = config('custom.orders_list_sort_map');

        $query = Order::join(
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
        );

        if (array_key_exists('search_key', $data)) {
            $searhKey = "%".$data['search_key']."%";

            $noteMatchedOrderQuery = "";
            if (array_key_exists('search_note', $data) && (!empty($noteMatches))) {
                $noteMatchedOrderQuery = "+(`orders`.`id` in (".implode(',', $noteMatches)."))";
            }

            $query->addSelect(
                DB::raw(
                    "(if((concat(payments.name, ':#:', ifnull(orders.name,'')) like ? ), 20, 0)+
                     if((concat(payments.reference, ':#:', payments.email) like ? ), 8, 0)+
                     if((concat(ifnull(orders.entry,''), ':#:', ifnull(orders.email,''), ':#:', ifnull(orders.paypal_name,'')) like ? ), 5, 0)+
                     if((concat(ifnull(orders.url,''), ':#:', ifnull(orders.stats,''), ':#:', ifnull(orders.screenshot,'')) like ? ), 2, 0)
                     ".$noteMatchedOrderQuery.") as searchrank"
                )
            )->setBindings(
                array_merge($query->getBindings(),
                [$searhKey,$searhKey,$searhKey,$searhKey])
            )->whereRaw(
                "(if((concat(payments.name, ':#:', ifnull(orders.name,'')) like ? ), 20, 0)+
                if((concat(payments.reference, ':#:', payments.email) like ? ), 8, 0)+
                if((concat(ifnull(orders.entry,''), ':#:', ifnull(orders.email,''), ':#:', ifnull(orders.paypal_name,'')) like ? ), 5, 0)+
                if((concat(ifnull(orders.url,''), ':#:', ifnull(orders.stats,''), ':#:', ifnull(orders.screenshot,'')) like ? ), 2, 0)".
                $noteMatchedOrderQuery.") > 0",
                [$searhKey,$searhKey,$searhKey,$searhKey]
            );

            $defaultSorter = ['searchrank' => 'desc']+$defaultSorter;

        }

        if (array_key_exists('filters', $data)) {
            $query->whereIn('orders.status', $data['filters']);
        }

        $sorter = $defaultSorter;

        if (array_key_exists('sort', $data)) {

            $sortIndex = $data['sort']['index'];

            $sorter = [
                $sortingMap[$sortIndex][0] => $data['sort']['direction']
            ];

            $secondarySorter = $defaultSorter;

            if (is_array($sortingMap[$sortIndex][1])) {
                $secondarySorter = $sortingMap[$sortIndex][1];
            }

            foreach ($secondarySorter as $column => $direction) {
                $sorter[$column] = $direction;
            }

        }

        foreach ($sorter as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query->paginate(config('custom.orders_list_per_page'));

    }

}
