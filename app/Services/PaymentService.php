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
        $this->validate($data);

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
    private function validate(array $data)
    {
        $validator = Validator::make($data, [
            'reference' => 'required|string|max:100',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'amount' => 'required|numeric|between:0,999999.99',
            'date' => 'required|date_format:Y-m-d H:i:s'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}
