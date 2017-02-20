<?php
namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;
use App\Order;
use Validator;

class OrderService
{

    private $orderRepository;
    private $paymentService;
    private $noteService;

    public function __construct(
        OrderRepository $orderRepository,
        PaymentService $paymentService,
        NoteService $noteService
    ) {
        $this->orderRepository = $orderRepository;
        $this->paymentService = $paymentService;
        $this->noteService = $noteService;
    }

    public function create(array $data)
    {

        $this->validate($data);

        $payment = $this->paymentService->createIfNotExist($data['payment']);

        $order = new Order;
        $order->payment = $payment->id;

        foreach ($data['order'] as $key => $value) {
            $order->$key = $value;
        }

        $this->orderRepository->save($order);

        if (array_key_exists('note', $data)) {
            $this->noteService->create($order, Auth::user(), $data);
        }

        return $order;

    }


    /**
     * Validate and throw ValidationException if data is invalid.
     *
     * @param array $data
     */
    private function validate(array $data)
    {

        $this->paymentService->validate($data['payment']);

        $validator = Validator::make($data['order'], [
            'entry' => 'nullable|string|max:25',
            'type' => 'integer|between:0,65535|exists:order_types,id',
            'name' => 'string|max:100',
            'email' => 'string|max:100',
            'paypal_name' => 'string|max:100',
            'clicks' => 'integer|between:0,65535',
            'put_on_top' => 'boolean',
            'date_submitted' => 'nullable|date_format:Y-m-d H:i:s',
            'url' => 'url|max:250',
            'stats' => 'url|max:250',
            'in_rotator' => 'boolean',
            'clicks_sent' => 'integer|between:0,65535',
            'optins' => 'integer|between:0,65535',
            'followup_sent' => 'boolean',
            'screenshot' => 'url|max:250',
            'priority' => 'integer|between:0,255',
            'status' => 'integer|between:0,65535|exists:order_statuses,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}
