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

        if(
            !((array_key_exists('id', $data) && $payment = $this->paymentRepository->findById($data['id'])) ||
            $payment = $this->paymentRepository->findByReference($data['reference']))
        ) {

            $payment = new Payment;

            foreach ($data as $key => $value) {
                $payment->$key = $value;
            }

            $this->paymentRepository->save($payment);

        }

        return $payment;

    }

    public function getMatch(array $data)
    {

        $this->validateMatch($data);

        return $this->paymentRepository->findMatch($data['query']);

    }

    private function validateMatch(array $data){

        $validator = Validator::make($data, [
            'query' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }


    /**
     * Validate and throw ValidationException if data is invalid.
     *
     * @param array $data
     */
    public function validate(array $data)
    {

        $messages = [
            'required_without' => 'The :attribute is required.'
        ];

        $validator = Validator::make($data, [
            'payment.id' => 'nullable|integer|between:0,65535|exists:payments,id',
            'payment.reference' => 'required_without:payment.id|string|max:100',
            'payment.gateway' => 'required_without:payment.id|integer|between:0,65535|exists:payment_gateways,id',
            'payment.name' => 'required_without:payment.id|string|max:50',
            'payment.email' => 'required_without:payment.id|email|max:100',
            'payment.amount' => 'required_without:payment.id|numeric|between:0,999999.99',
            'payment.date' => 'required_without:payment.id|date_format:Y-m-d H:i:s'
        ], $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}
