<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\Account\AccountCollection;
use App\Http\Resources\V1\Transation\Transaction;
use App\Http\Resources\V1\Transation\TransactionCollection;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class User extends JsonResource
{
    private string $application_token;

    #[Pure] public function __construct($resource, $application_token=null)
    {
        parent::__construct($resource);

        $this->application_token = $application_token;

    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'username'=>$this->username,
//            'password'=>$this->password,
            'email'=>$this->email,
            'scopes'=>$this->scopes,
            'finotech_token'=>$this->finotech_token,
            'application_token'=>$this->application_token,
            'accounts'=>new AccountCollection($this->accounts),
            'transactions_as_source'=>new TransactionCollection($this->transactions_as_source),
            'transactions_as_destination'=>new TransactionCollection($this->transactions_as_destination)
        ];
    }
}
