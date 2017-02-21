<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Responses\AjaxResponse;

class PaymentController extends Controller
{

    private $paymentService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        PaymentService $paymentService
    ) {
        $this->paymentService = $paymentService;
        $this->middleware('auth');
    }


    public function getAutoCompleteList(Request $request)
    {
        return new AjaxResponse($this->paymentService->getMatch($request->all()));
    }
}
