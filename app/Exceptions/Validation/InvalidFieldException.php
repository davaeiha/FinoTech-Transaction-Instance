<?php

namespace App\Exceptions\Validation;

use App\Exceptions\FinoTechException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;


class InvalidFieldException extends FinoTechException
{

    protected string $field;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, $trackId = null,$field)
    {
        parent::__construct($message, $code, $previous, $trackId);

        $this->field = $field;
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
                    'code'=> 'VALIDATION_ERROR',
                    'message'=> 'invalid '.$this->field,
                ]
            ],400) : parent::render($request);
    }
}
