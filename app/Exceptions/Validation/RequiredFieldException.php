<?php

namespace App\Exceptions\Validation;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Pure;
use Throwable;

class RequiredFieldException extends FinoTechException
{
    protected string $field;


    #[Pure] public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, $trackId = null, $field)
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
                    'message'=> $this->field.' is required',
                ]
            ],428) : parent::render($request);
    }
}
