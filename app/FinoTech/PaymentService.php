<?php

namespace App\FinoTech;

use App\Exceptions\FinoTechException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class PaymentService
{
    const BASE_URL = 'https://sandboxapi.finnotech.ir/oak/v2/clients/';
    private string $trackId;
    private Client $restCall;


    public function __construct(string $trackId=null,string $finotech_token=null)
    {
        $this->trackId = $trackId;
        $headers = [
            'Content-type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$finotech_token,
        ];

        $this->restCall=new Client([
            'base_uri'=>self::BASE_URL,
            'headers'=>$headers
        ]);
    }

    /**
     * @param array $params
     * @param int $clientID
     * @return JsonResponse
     * @throws FinoTechException
     * @throws GuzzleException
     */
    public function pay(array $params,int $clientID): JsonResponse
    {
        $encryptedToken = Crypt::encryptString($this->trackId);
        try {
            $result = $this->restCall->post(self::BASE_URL . "{$clientID}/transferTo?trackId={$encryptedToken}",
                ['body' => json_encode($params)]
            );

            return json_decode($result->getBody()->getContents(), false);

        } catch (\Exception $exception) {
            throw new FinoTechException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }
}
