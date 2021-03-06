<?php
namespace App\Repositories;

use App\Payment;
use DB;

class PaymentRepository
{

    public function save(Payment $payment)
    {

        $saved = false;

        DB::transaction(function () use ($payment, &$saved) {

            $saved = $payment->save();

        });

        if (!$saved) {
            abort(500, "Something went wrong!! Can't save Payment");
        }

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

    public function findById($id)
    {
        return Payment::where('id','=', $id)->first();
    }

}
