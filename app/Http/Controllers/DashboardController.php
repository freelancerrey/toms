<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PaymentGatewayRepository;
use App\Services\OrderTypeService;

class DashboardController extends Controller
{

    private $orderStatusRepository;
    private $paymentGatewayRepository;
    private $orderTypeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderStatusRepository $orderStatusRepository,
        PaymentGatewayRepository $paymentGatewayRepository,
        OrderTypeService $orderTypeService
    ) {
        $this->orderStatusRepository = $orderStatusRepository;
        $this->paymentGatewayRepository = $paymentGatewayRepository;
        $this->orderTypeService = $orderTypeService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', [
            'order_statuses' => $this->orderStatusRepository->getAllForView(),
            'payment_gateways' => $this->paymentGatewayRepository->getAllForView(),
            'order_type_mappings' => $this->orderTypeService->getMappings()
        ]);
    }
}
