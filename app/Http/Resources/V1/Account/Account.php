<?php

namespace App\Http\Resources\V1\Account;

use Illuminate\Http\Resources\Json\JsonResource;

class Account extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'account_no'=>$this->account_no,
            'sheba_no'=>$this->sheba_no,
            'payment_no'=>$this->payment_no,
            'registered_at'=>$this->created_at,
            'bank'=>$this->bank->title
        ];
    }
}
