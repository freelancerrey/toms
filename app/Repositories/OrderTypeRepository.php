<?php
namespace App\Repositories;

use App\OrderType;

class OrderTypeRepository
{

    public function getAllActive()
    {

        return OrderType::where('is_active', true)
        ->orderBy('id')
        ->get()
        ->toArray();

    }

}
