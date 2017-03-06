<?php
namespace App\Repositories;

use App\PaymentGateway;

class PaymentGatewayRepository
{

    public function getAllActive()
    {

        return PaymentGateway::where('is_active', true)
        ->orderBy('id')
        ->get()
        ->toArray();

    }

    public function getDescriptionById($id)
    {

        return PaymentGateway::where('id', '=', $id)->pluck('gateway')->toArray()[0];

    }

}
