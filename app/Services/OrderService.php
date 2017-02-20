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

        $this->paymentService->validate($data);

        $validator = Validator::make($data, [
            'order.entry' => 'nullable|string|max:25',
            'order.type' => 'integer|between:0,65535|exists:order_types,id',
            'order.name' => 'string|max:100',
            'order.email' => 'email|max:100',
            'order.paypal_name' => 'string|max:100',
            'order.clicks' => 'integer|between:0,65535',
            'order.put_on_top' => 'boolean',
            'order.date_submitted' => 'nullable|date_format:Y-m-d H:i:s',
            'order.url' => 'url|max:250',
            'order.stats' => 'url|max:250',
            'order.in_rotator' => 'boolean',
            'order.clicks_sent' => 'integer|between:0,65535',
            'order.optins' => 'integer|between:0,65535',
            'order.followup_sent' => 'boolean',
            'order.screenshot' => 'url|max:250',
            'order.priority' => 'integer|between:0,255',
            'order.status' => 'integer|between:0,65535|exists:order_statuses,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

}
