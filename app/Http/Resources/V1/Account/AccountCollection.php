<?php

namespace App\Http\Resources\V1\Account;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return $this->collection->map(function ($account){
            return [
                'account_no'=>$account->account_no,
                'payment_no'=>$account->payment_no,
                'bank'=>$account->bank
            ];
        })->toArray();
    }
}
