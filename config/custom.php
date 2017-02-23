<?php

return [

    'version' => '1.0',

    'gravity_api_key' => env('GRAVITY_API_KEY'),

    'gravity_private_key' => env('GRAVITY_PRIVATE_KEY'),

    'orders_list_per_page' => 10,

    'default_orders_list_sort' => [
        'orders.priority' => 'desc',
        'orders.id' => 'asc'
    ],

    'orders_list_sort_map' => [
        0 => ['orders.id',[]],
        1 => ['payments.name', null],
        2 => ['payments.date', null],
        3 => ['orders.type', null],
        4 => ['orders.name', null],
        5 => ['orders.clicks', null],
        6 => ['orders.date_submitted', null],
        7 => ['orders.priority', ['id' => 'asc']],
        8 => ['orders.status', null]
    ]

];
