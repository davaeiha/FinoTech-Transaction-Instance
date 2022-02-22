<?php

namespace App\Exceptions\Validation;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvalidUrlException extends FinoTechException
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
                    'code'=> 'VALIDATION_ERROR',
                    'message'=> 'invalid requested url',
                ]
            ],406) : parent::render($request);
    }
}
