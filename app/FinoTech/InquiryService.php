<?php

namespace App\FinoTech;

use App\Exceptions\FinoTechException;
use App\Exceptions\Scope\InvalidScopeException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Crypt;

class InquiryService
{
    const BASE_URL = 'https://sandboxapi.finnotech.ir/oak/v2/clients/';
    private Client $resCall;
    private string $inquiryUri;
    private string $title;
    private string $trackId;
    private string $inquiryTrackId;
    private string $scopes;


    public function __construct(string $title = null,string $trackId = null,string $inquiryTrackId = null,string $finotech_token=null,array $scopes=null)
    {
        $this->trackId = $trackId;
        $this->inquiryTrackId = $inquiryTrackId;
        $this->scopes = $scopes;
        $this->title = trim(strtolower($title));

        $headers = [
            'Content-Type'=> 'application/json',
            'Accept' => 'application/json',
            'Authorization' => "Bearer {$finotech_token}"
        ];

        $this->resCall = new Client([
            'headers'=>$headers,
            'base_uri'=>self::BASE_URL
        ]);

    }

    /**
     * @param int $clientId
     * @return mixed
     * @throws FinoTechException
     * @throws GuzzleException
     */
    public function inquiry(int $clientId): mixed
    {
        try {
            $this->setInquiryUri($clientId);
            $encryptedToken = Crypt::encryptString($this->trackId);
            $result = $this->resCall->get($this->inquiryUri,[
                'query'=>[
                    'trackId' =>$encryptedToken,
                    'inquiryTrackId'=>$this->inquiryTrackId
                ]
            ]);

            return json_decode($result->getBody()->getContents(),false);
        }catch (\Exception $e){
            throw new FinoTechException($e->getMessage(),$e->getCode(),$e->getPrevious());
        }

    }

    /**
     * @param $clientId
     * @return void
     * @throws FinoTechException
     */
    private function setInquiryUri($clientId){
        if ($this->title == 'paya'){
            if (!in_array('proxy-inquiry-get',$this->scopes))
                throw  new InvalidScopeException();

            $this->inquiryUri = self::BASE_URL."/$clientId/proxyInquiry";
        }elseif($this->title == 'internal'){
            if (!in_array('inquiry-transfer-get',$this->scopes))
                throw  new InvalidScopeException();


            $this->inquiryUri = self::BASE_URL."/$clientId/transferInquiry";
        }else{
            throw new FinoTechException('transaction type not supported',400);
        }
    }

}
