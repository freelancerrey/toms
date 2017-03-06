<?php
namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\OrderRepository;
use App\Repositories\NoteRepository;
use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Order;
use Validator;

class OrderService
{

    private $orderRepository;
    private $noteRepository;
    private $logRepository;
    private $paymentService;
    private $noteService;

    public function __construct(
        OrderRepository $orderRepository,
        NoteRepository $noteRepository,
        LogRepository $logRepository,
        PaymentService $paymentService,
        NoteService $noteService
    ) {
        $this->orderRepository = $orderRepository;
        $this->noteRepository = $noteRepository;
        $this->logRepository = $logRepository;
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

        if (array_key_exists('note', $data) && !is_null($data['note'])) {
            $this->noteService->create($order, Auth::user(), $data);
        }

        return $order;

    }

    public function update(array $data)
    {

        $this->validateId($data);
        $this->validate($data);

        $order = $this->orderRepository->getById($data['id']);

        $payment = $this->paymentService->createIfNotExist($data['payment']);
        $order->payment = $payment->id;

        foreach ($data['order'] as $key => $value) {
            $order->$key = $value;
        }

        $this->orderRepository->save($order);

        if (array_key_exists('note', $data) && !is_null($data['note'])) {
            $this->noteService->create($order, Auth::user(), $data);
        }

        return $order;

    }

    public function getDetail(array $data)
    {

        $this->validateId($data);

        $details = $this->orderRepository->getRecord($data['id']);

        $details['notes'] = $this->noteRepository->getForOrder($data['id']);

        $details['logs'] = $this->logRepository->getAllByOrder($data['id']);

        return $details;

    }

    public function getList(array $data)
    {

        $this->validateQuery($data);

        $noteMatches = [];
        if (array_key_exists('search_note', $data)) {
            $noteMatches = $this->noteService->search($data['search_key']);
        }

        return $this->orderRepository->getList($data, $noteMatches);

    }

    private function validateId(array $data)
    {

        $validator = Validator::make($data, [
            'id' => 'required|integer|between:0,65535|exists:orders,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

    private function validateQuery(array $data)
    {

        $validator = Validator::make($data, [
            'sort' => 'array',
            'page' => 'integer|between:0,65535',
            'sort.index' => [
                'integer',
                Rule::in(array_keys(config('custom.orders_list_sort_map')))
            ],
            'sort.direction' => 'string|in:asc,desc',
            'filters' => 'array',
            'filters.*' => 'integer|between:0,65535',
            'search_key' => 'string|max:250',
            'search_note' => 'boolean'
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
    private function validate(array $data)
    {

        $this->paymentService->validate($data);

        $validator = Validator::make($data, [
            'order.entry' => 'nullable|string|max:25',
            'order.type' => 'nullable|integer|between:0,65535|exists:order_types,id',
            'order.name' => 'nullable|string|max:100',
            'order.email' => 'nullable|email|max:100',
            'order.paypal_name' => 'nullable|string|max:100',
            'order.clicks' => 'nullable|integer|between:0,65535',
            'order.put_on_top' => 'boolean',
            'order.date_submitted' => 'nullable|date_format:Y-m-d H:i:s',
            'order.url' => 'nullable|url|max:250',
            'order.stats' => 'nullable|url|max:250',
            'order.in_rotator' => 'boolean',
            'order.clicks_sent' => 'nullable|integer|between:0,65535',
            'order.optins' => 'nullable|integer|between:0,65535',
            'order.followup_sent' => 'boolean',
            'order.screenshot' => 'nullable|url|max:250',
            'order.priority' => 'integer|between:0,'.config('custom.priority_level'),
            'order.status' => 'integer|between:0,65535|exists:order_statuses,id'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

        if (array_key_exists('note', $data) && !is_null($data['note'])) {
            $this->noteService->validate($data);
        }

    }

}
