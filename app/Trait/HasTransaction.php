<?php

namespace App\Trait;

use App\Enums\ReasonEnum;
use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Account\MaxAmountException;
use App\Models\Client\Client;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

trait HasTransaction{

    protected array $accountData=[];


    protected $destAccount;
    protected $sourceAccount;

    protected $destUser;
    protected $sourceUser;

    /**
     * validation input for transfer money
     *
     * @param Request $request
     * @return array
     */
    protected function validateInputs(Request $request): array
    {
        return $request->validate([
            'amount'=>'required|integer',
            'source_account_no'=>'string|required_without_all:source_sheba_no,source_payment_no',
            'source_sheba_no'=>'string|required_without_all:source_account_no,source_payment_no',
            'source_payment_no'=>'integer|required_without_all:source_sheba_no,source_account_no',

            'dest_account_no'=>'string|required_without_all:dest_sheba_no,dest_payment_no',
            'dest_sheba_no'=>'string|required_without_all:dest_account_no,dest_payment_no',
            'dest_payment_no'=>'integer|required_without_all:dest_sheba_no,dest_account_no',

            'description'=>'string',
            'transaction_type'=>['required',Rule::in(['Paya','Internal'])],
            'reason'=>[new Enum(ReasonEnum::class)]
        ]);
    }

    /**
     * set account data for finding Account
     * @param string $prefix
     * @param array $validatedData
     * @return void
     */
    protected function setAccountData(string $prefix,array $validatedData){
        $this->accountData["{$prefix}_account_no"]=$validatedData["{$prefix}_account_no"] ?? null;
        $this->accountData["{$prefix}_sheba_no"]=$validatedData["{$prefix}_sheba_no"] ?? null;
        $this->accountData["{$prefix}_payment_no"]=$validatedData["{$prefix}_payment_no"] ?? null;
    }

    /**
     * find destination and source account
     *
     * @throws AccountNotFoundException
     */
    protected function findAccount($prefix,$validatedData)
    {

        $this->setAccountData($prefix,$validatedData);

        $query = DB::table('bank_account')
            ->where('user_id','=',auth()->user()->id);

        foreach ($this->accountData as $key =>$value){
            if (is_null($value)){
                continue;
            }
            $query = DB::table('bank_account')
                ->where($key,'=',$value)
                ->union($query);
        }

        $this->accountData=[];

        return DB::table('bank_account')
                ->union($query)
                ->first() ?? throw new AccountNotFoundException('','','',$this->trackId);
    }



    /**
     * generate transaction and store data in database
     *
     * @param $validatedData
     * @return Model|Builder
     * @throws AccountNotFoundException
     */
    protected function generateTransaction($validatedData): Model|Builder
    {
        $this->destAccount = $this->findAccount('dest',$validatedData);

        $this->sourceAccount = $this->findAccount('source',$validatedData);

        $type = TransactionType::query()
            ->where('title','=',$validatedData['transaction_type'])
            ->first();

        return Transaction::query()->create([
            'source_account_id'=>$this->sourceAccount->id,
            'destination_account_id'=>$this->destAccount->id,
            'payment_time'=>Carbon::now()->format('Y-m-d H:i:s'),
            'amount'=>$validatedData['amount'],
            'description'=>$validatedData['description'],
            'reason'=>$validatedData['reason'],
            'status'=>"PENDING",
            'type_id'=>$type->id
        ]);
    }

    /**
     * generate args for passing to the finotech account
     *
     * @param $validatedData
     * @return array
     */
    protected function generateArgs($validatedData){
        return [
            'amount'=>$validatedData['amount'],
            'description'=>$validatedData['description'] ?? null,
            'destinationFirstname'=>$this->destUser->first_name,
            'destinationLastname'=>$this->destUser->last_name,
            'destinationNumber'=> $this->destAccount->account_no ?? $this->destAccount->sheba_no,
            'paymentNumber'=>$this->destAccount->payment_no,
            'sourceFirstName'=>$this->sourceUser->first_name,
            'sourceLastName'=>$this->sourceUser->last_name,
            'secondPassword'=>Hash::make(Str::random(16))
        ];
    }


    protected function validateAmount($type , $amount,$trackId){
        if($type == 'Paya'){
            if (
                $amount > 99999999
            ){
                throw new MaxAmountException('','','',$trackId,99999999);
            }
        }
    }
}
