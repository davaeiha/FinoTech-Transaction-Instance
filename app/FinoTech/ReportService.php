<?php

namespace App\FinoTech;

use App\Exceptions\FinoTechException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;

class ReportService
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

    public function report($clientId,$deposits,$validatedData){
        $encryptedToken = Crypt::encryptString($this->trackId);
        try {
            $result = $this->restCall->get(self::BASE_URL."{$clientId}/deposits/{$deposits}/payas",[
                'query'=>[
                    'trackId'=>$encryptedToken,
                    'fromDate'=>$validatedData['fromDate'],
                    'toDate'=>$validatedData['toDate'],
                    'offset'=>$validatedData['offset'] ?? 0,
                    'length'=>$validatedData['length'] ?? 20
                ]
            ]);

            return json_decode($result->getBody()->getContents(), false);
        }catch (\Exception $exception){
            throw new FinoTechException($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }
    }
}
