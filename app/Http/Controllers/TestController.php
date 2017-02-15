<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PaymentRepository;
use App\Services\PaymentService;

class TestController extends Controller
{

    private $paymentRepository;
    private $paymentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PaymentRepository $paymentRepository,
        PaymentService $paymentService
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->paymentService = $paymentService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->paymentService->create([
            'reference' => 'PP#JFSLDF2K203dw33423',
            'payment_name' => 'Rey C. Fernandez',
            'payment_email' => 'nxmreycfernandez@gmail.com',
            'amount' => 1200.34,
            'payment_date' => '2017-02-14'
        ]);
    }
}
