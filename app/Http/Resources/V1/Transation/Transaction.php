<?php

namespace App\Http\Resources\V1\Transation;

use App\Http\Resources\V1\Account\Account;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Transaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id'=>$this->id,
            'source_account'=>new Account($this->sourceAccount),
            'destination_account'=>new Account($this->destAccount),
            'payment_time'=>$this->payment_time,
            'amount'=>$this->amount,
            'description'=>$this->description,
            'reason'=>$this->reason,
            'type'=>$this->type,
            'ref_code'=>$this->ref_code,
            'status'=>$this->status,
        ];
    }
}
