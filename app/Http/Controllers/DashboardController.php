<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PaymentGatewayRepository;

class DashboardController extends Controller
{

    private $orderStatusRepository;
    private $paymentGatewayRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderStatusRepository $orderStatusRepository,
        PaymentGatewayRepository $paymentGatewayRepository
    ) {
        $this->orderStatusRepository = $orderStatusRepository;
        $this->paymentGatewayRepository = $paymentGatewayRepository;
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
            'payment_gateways' => $this->paymentGatewayRepository->getAllForView()
        ]);
    }
}
