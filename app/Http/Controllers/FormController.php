<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FormService;
use App\Http\Responses\AjaxResponse;

class FormController extends Controller
{

    private $formService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        FormService $formService
    ) {
        $this->formService = $formService;
        $this->middleware('auth');
    }


    public function getCallUrl(Request $request)
    {
        return new AjaxResponse($this->formService->getCallUrl($request->all()));
    }
}
