<?php

namespace App\Exceptions\Client;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class DuplicateClientException extends FinoTechException
{

    protected string $email;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, $trackId = null,$email=null)
    {
        parent::__construct($message, $code, $previous, $trackId);

        $this->email = $email;
    }

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
                    'code'=> 'DUPLICATE_CLIENT_ERROR',
                    'message'=> "Client with email {$this->email} is registered before",
                ]
            ],400) : parent::render($request);
    }
}
