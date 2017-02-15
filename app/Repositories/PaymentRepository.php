<?php
namespace App\Repositories;

use App\Payment;
use DB;

class PaymentRepository
{

    public function save(Payment $payment)
    {

        DB::transaction(function () use ($payment) {

            $payment->save();

        });

    }

    public function findByReference($reference)
    {
        return Payment::where('reference', $reference)->first();
    }

}
