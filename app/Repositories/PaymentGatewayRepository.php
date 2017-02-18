<?php
namespace App\Repositories;

use App\PaymentGateway;

class PaymentGatewayRepository
{

    public function getAllForView()
    {

        return PaymentGateway::where('is_active', true)
        ->orderBy('id')
        ->get()
        ->toArray();

    }

}
