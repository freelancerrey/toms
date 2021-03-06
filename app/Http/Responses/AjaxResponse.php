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
    public function __construct($data = [], $status = 200)
    {
        parent::__construct(
            $data,
            $status,
            ['Content-Type' => 'application/json; charset=utf-8']
        );
    }

}
