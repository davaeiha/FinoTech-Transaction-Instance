<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Enums\ReasonEnum;
use App\Exceptions\FinoTechException;
use App\FinoTech\PaymentService;
use App\Http\Controllers\Controller;
use App\Trait\HasRequest;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Trait\HasTransaction;

class TransactionController extends Controller
{
    use HasTransaction,
        HasRequest;
    /**
     *
     * @throws FinoTechException|GuzzleException
     */
    public function transaction(Request $request): JsonResponse
    {
        //validate inputs
        $validatedData = $this->validateInputs($request);
        //source user and dest user
        $this->sourceUser = auth()->user();
        $this->destUser = $this->destAccount->user;
        //generate track id
        $this->generateTrackId($this->sourceUser);
        //validate amount
        $this->validateAmount($validatedData['type'],$validatedData['amount'],$this->trackId);
        //transaction
        $transaction = $this->generateTransaction($validatedData);
        //generate args for sending to finotech service
        $args = $this->generateArgs($validatedData);


        $payment = new PaymentService($this->trackId,$this->sourceUser->finotech_token);
        $result = $payment->pay($args,$this->client->id);

        $transaction->update([
            'ref_code'=>$result->ref_code,
            'status'=>"DONE"
        ]);

        return \response()->json([
            'result'=>$result,
            'statues'=>'DONE',
            'trackId'=>$this->trackId
        ],200);
    }

}
