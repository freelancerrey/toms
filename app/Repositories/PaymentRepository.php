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

    public function findMatch($query)
    {
        return Payment::select('id', 'reference as label')
               ->where('reference', 'like', $query.'%')
               ->get()
               ->toArray();
    }

    public function findByReference($reference)
    {
        return Payment::where('reference', $reference)->first();
    }

}
