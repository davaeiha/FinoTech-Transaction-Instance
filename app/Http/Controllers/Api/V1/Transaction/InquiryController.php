<?php

namespace App\Http\Controllers\Api\V1\Transaction;

use App\Exceptions\FinoTechException;
use App\FinoTech\InquiryService;
use App\Http\Controllers\Controller;
use App\Models\Transaction\Transaction;
use App\Trait\HasRequest;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    use HasRequest;

    /**
     * @throws GuzzleException
     * @throws FinoTechException
     */
    public function inquiry(Transaction $transaction): JsonResponse
    {
        $user = auth()->user();
        //get title of type
        $type = $transaction->type;
        $title = $type->title;

        $this->generateTrackId($user);

        $inquiry = new InquiryService(
            $title,
            $this->trackId,
            $transaction->ref_code,
            $user->finotech_token
        );

        $result = $inquiry->inquiry($this->client->id);

        return \response()->json([
            'result'=>$result,
            'statues'=>'DONE',
            'trackId'=>$this->encryptedToken
        ],200);
    }
}
