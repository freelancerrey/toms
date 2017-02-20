<?php
namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\PaymentRepository;
use App\Payment;
use Validator;

class PaymentService
{

    private $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    public function createIfNotExist(array $data)
    {
        //$this->validate($data); validation will on the caller side

        if(!$payment = $this->paymentRepository->findByReference($data['reference'])) {

            $payment = new Payment;

            foreach ($data as $key => $value) {
                $payment->$key = $value;
            }

            $this->paymentRepository->save($payment);

        }

        return $payment;

    }


    /**
     * Validate and throw ValidationException if data is invalid.
     *
     * @param array $data
     */
    public function validate(array $data)
    {
        $validator = Validator::make($data, [
            'payment.reference' => 'required|string|max:100',
            'payment.gateway' => 'required|integer|between:0,65535|exists:payment_gateways,id',
            'payment.name' => 'required|string|max:50',
            'payment.email' => 'required|email|max:100',
            'payment.amount' => 'required|numeric|between:0,999999.99',
            'payment.date' => 'required|date_format:Y-m-d H:i:s'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}
