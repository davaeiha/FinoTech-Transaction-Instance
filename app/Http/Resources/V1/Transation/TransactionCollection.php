<?php

namespace App\Http\Resources\V1\Transation;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request):array
    {
        return $this->collection->map(function ($trans){
            return [
                'payment_time'=>$trans->payment_time,
                'amount'=>$trans->amount,
                'type'=>$trans->type,
                'status'=>$trans->status
            ];
        })->toArray();
    }
}
