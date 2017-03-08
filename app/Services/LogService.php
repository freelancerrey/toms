<?php

namespace App\Services;

use App\Order;
use App\Note;
use App\Payment;
use App\Repositories\LogRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\OrderTypeRepository;
use App\Repositories\OrderStatusRepository;
use DateTime;

class LogService
{

    private $excludedPaymentFields;
    private $excludedOrderFields;
    private $booleanFields;

    private $logRepository;
    private $paymentGatewayRepository;
    private $orderTypeRepository;
    private $orderStatusRepository;

    public function __construct(
        LogRepository $logRepository,
        PaymentGatewayRepository $paymentGatewayRepository,
        OrderTypeRepository $orderTypeRepository,
        OrderStatusRepository $orderStatusRepository
    ) {
        $this->logRepository = $logRepository;
        $this->paymentGatewayRepository = $paymentGatewayRepository;
        $this->orderTypeRepository = $orderTypeRepository;
        $this->orderStatusRepository = $orderStatusRepository;

        $this->excludedPaymentFields = ['id', 'created_at', 'updated_at'];
        $this->excludedOrderFields = ['id', 'payment', 'created_at', 'updated_at'];
        $this->booleanFields = ['put_on_top', 'in_rotator', 'followup_sent'];
    }

    public function createForNewOrder(Order $order, $userId, DateTime $dateTime)
    {

        $logs = [];
        $order = $order->toArray();

        $this->createForPayment($logs, $order['id'], $order['payment'], $userId, $dateTime, "Set");

        foreach ($order as $field => $value) {

            if($value && !in_array($field, $this->excludedOrderFields)) {

                $fieldName = ucwords(str_replace('_', " ", $field));
                $value = $this->mapValue($field, $value);

                $logs[] = [
                    'order' => $order['id'],
                    'user' => $userId,
                    'log' => "Set <#>".$fieldName."</#> to <*>".$value."</*>",
                    'created_at' => $dateTime
                ];

            }

        }

        $logs[] = [
            'order' => $order['id'],
            'user' => $userId,
            'log' => "Created <#>Order</#> with ID: <*>".$order['id']."</*>",
            'created_at' => $dateTime
        ];

        $this->logRepository->insert($logs);

    }


    public function createForUpdatedOrder(Order $order, $userId, DateTime $dateTime)
    {

        $logs = [];

        foreach($order->getDirty() as $field => $value){

            if ($field != "updated_at") {

                if ($field == "payment") {

                    $this->createForPayment($logs, $order->id, $value, $userId, $dateTime);

                } else {

                    $fieldName = ucwords(str_replace('_', " ", $field));
                    $action = ($value && $order->getOriginal($field))? "Updated":"Set";
                    $value = $this->mapValue($field, $value);

                    $logs[] = [
                        'order' => $order->id,
                        'user' => $userId,
                        'log' => $action." <#>".$fieldName."</#> to <*>".$value."</*>",
                        'created_at' => $dateTime
                    ];

                }

            }

        }

        if (sizeof($logs))
            $this->logRepository->insert($logs);

    }

    public function createForNote(Note $note, $userId, DateTime $dateTime)
    {

        $note = $note->toArray();

        $this->logRepository->insert([
            'order' => $note['order'],
            'user' => $userId,
            'log' => "Added <#>Note</#> with ID <*>".$note['id']."</*>",
            'created_at' => $dateTime
        ]);

    }


    private function mapValue($field, $value)
    {
        if(in_array($field, $this->booleanFields)){
            $value = ($value)? "TRUE":"FALSE";
        } else if($field == "type") {
            $value = (!$value)? "NONE":$this->orderTypeRepository->getDescriptionById($value);
        } else if($field == "status") {
            $value = $this->orderStatusRepository->getDescriptionById($value);
        } else {
            $value = (!$value)? "NONE":$value;
        }

        return $value;
    }


    private function createForPayment(&$logs, $orderId, $paymentId, $userId, DateTime $dateTime, $action = "Updated")
    {

        $payment = Payment::find($paymentId)->toArray();

        foreach ($payment as $field => $value) {
            if(!in_array($field, $this->excludedPaymentFields)){
                if($field == "gateway"){
                    $value = $this->paymentGatewayRepository->getDescriptionById($value);
                }
                $logs[] = [
                    'order' => $orderId,
                    'user' => $userId,
                    'log' => $action." <#>Payment ".ucfirst($field)."</#> to <*>".$value."</*>",
                    'created_at' => $dateTime
                ];
            }
        }

    }

}
