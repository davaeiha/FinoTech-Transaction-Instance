<?php

namespace App\Exceptions\Scope;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UnauthorizedScopeException extends FinoTechException
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
                    'code'=> 'UNAUTHORIZED',
                    'message'=> 'unauthorized scope',
                ]
            ],401) : parent::render($request);

    }
}
