<?php

namespace App\Exceptions\Account;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AccountNotFoundException extends FinoTechException
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return $request->expectsJson() ?
            response()->json([
                'status'=> 'FAILED',
                'trackId'=> $this->encryptedTrackId,
                'error'=> [
                    'code'=> 'ACCOUNT_NOT_FOUND',
                    'message'=> "account for {$request->user()->first_name} {$request->user()->last_name} not found",
                ]
            ],404) : parent::render($request);
    }
}
