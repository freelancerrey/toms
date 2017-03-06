<?php

namespace App\Observers;

use App\Order;
use App\Payment;
use App\Repositories\LogRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Repositories\OrderTypeRepository;
use App\Repositories\OrderStatusRepository;
use Illuminate\Support\Facades\Auth;
use DateTime;

class OrderObserver
{

    private $excludedPaymentFields;
    private $excludedOrderFields;
    private $booleanFields;
    private $userId;

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
        $this->userId = Auth::id();
    }

    public function created(Order $order)
    {

        $logs = [];
        $order = $order->toArray();

        $logs[] = [
            'order' => $order['id'],
            'user' => $this->userId,
            'log' => "Created <#>Order</#> with ID: <*>".$order['id']."</*>",
            'created_at' => new DateTime()
        ];

        $this->createPaymentLogs($logs, $order['id'], $order['payment'], "Set");

        foreach ($order as $field => $value) {

            if($value && !in_array($field, $this->excludedOrderFields)) {

                $fieldName = ucwords(str_replace('_', " ", $field));
                $value = $this->mapValue($field, $value);

                $logs[] = [
                    'order' => $order['id'],
                    'user' => $this->userId,
                    'log' => "Set <#>".$fieldName."</#> to <*>".$value."</*>",
                    'created_at' => new DateTime()
                ];

            }

        }

        if (sizeof($logs))
            $this->logRepository->insert($logs);

    }

    public function updated(Order $order)
    {

        $logs = [];

        foreach($order->getDirty() as $field => $value){

            if ($field != "updated_at") {

                if ($field == "payment") {

                    $this->createPaymentLogs($logs, $order->id, $value);

                } else {

                    $fieldName = ucwords(str_replace('_', " ", $field));
                    $action = ($value && $order->getOriginal($field))? "Updated":"Set";
                    $value = $this->mapValue($field, $value);

                    $logs[] = [
                        'order' => $order->id,
                        'user' => $this->userId,
                        'log' => $action." <#>".$fieldName."</#> to <*>".$value."</*>",
                        'created_at' => new DateTime()
                    ];

                }

            }

        }

        if (sizeof($logs))
            $this->logRepository->insert($logs);

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

    private function createPaymentLogs(&$logs, $orderId, $paymentId, $action = "Updated")
    {

        $payment = Payment::find($paymentId)->toArray();

        foreach ($payment as $field => $value) {
            if(!in_array($field, $this->excludedPaymentFields)){
                if($field == "gateway"){
                    $value = $this->paymentGatewayRepository->getDescriptionById($value);
                }
                $logs[] = [
                    'order' => $orderId,
                    'user' => $this->userId,
                    'log' => $action." <#>Payment ".ucfirst($field)."</#> to <*>".$value."</*>",
                    'created_at' => new DateTime()
                ];
            }
        }

    }

}
