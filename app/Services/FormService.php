<?php
namespace App\Services;

use App\Exceptions\ValidationException;
use GuzzleHttp\Client;
use Validator;
use DateTime;

class FormService
{

    public function getDetail(array $data)
    {

        $this->validate($data);

        $apiKey = config('custom.gravity_api_key');
        $privateKey = config('custom.gravity_private_key');

        $route = 'entries/' . $data['id'];
        $expires = (new DateTime())->modify('+60 mins')->getTimestamp();
        $stringToSign = sprintf('%s:%s:%s:%s', $apiKey, 'GET', $route, $expires);

        $signature = $this->calculateSignature ($stringToSign, $privateKey);

        $callUrl = 'https://www.humaneyeballs.com/gravityformsapi/' . $route . '?api_key=' . $apiKey . '&signature=' . $signature . '&expires=' . $expires;

        $client = new Client();
        $response = $client->request('GET', $callUrl);
        $response = json_decode($response->getBody(), true);

        return $response['response'];

    }


    /**
     * Validate and throw ValidationException if data is invalid.
     *
     * @param array $data
     */
    private function validate(array $data)
    {
        $validator = Validator::make($data, [
            'code' => 'required|string|max:2',
            'id' => 'required|integer|between:0,65535'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors());
        }

    }

    private function calculateSignature ($string, $privateKey)
    {
        $hash = hash_hmac('sha1', $string, $privateKey, true);
        $signature = rawurlencode(base64_encode($hash));
        return $signature;
    }

}
