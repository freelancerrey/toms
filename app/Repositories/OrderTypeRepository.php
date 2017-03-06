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

    public function getDescriptionById($id)
    {

        return OrderType::where('id', '=', $id)->pluck('type')->toArray()[0];

    }

}
