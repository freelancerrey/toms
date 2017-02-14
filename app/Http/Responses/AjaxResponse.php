<?php
namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class AjaxResponse extends JsonResponse
{
    /**
     * Constructor.
     *
     * @param  mixed  $data
     * @param  int    $status
     */
    public function __construct($data = [])
    {
        parent::__construct(
            $data,
            200,
            ['Content-Type' => 'application/json; charset=utf-8']
        );
    }

}
