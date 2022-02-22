<?php

namespace App\Exceptions\Account;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SameAccountException extends FinoTechException
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
                    'code'=> 'SAME_ACCOUNT_ERROR',
                    'message'=> 'Source And destination accounts are the same!',
                ]
            ],400) : parent::render($request);
    }
}
