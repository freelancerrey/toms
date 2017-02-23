<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Responses\AjaxResponse;

class OrderController extends Controller
{

    private $orderService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
        $this->middleware('auth');
    }


    public function postCreate(Request $request)
    {
        return new AjaxResponse($this->orderService->create($request->all()));
    }

    public function getList(Request $request){
        return new AjaxResponse($this->orderService->getList($request->all()));
    }

}
