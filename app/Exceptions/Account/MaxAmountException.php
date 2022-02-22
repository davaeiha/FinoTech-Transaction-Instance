<?php

namespace App\Exceptions\Account;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use phpseclib3\Math\PrimeField\Integer;
use Throwable;

class MaxAmountException extends FinoTechException
{

    protected int $maxAmount;

    #[Pure] public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, $trackId = null, $maxAmount=null)
    {
        parent::__construct($message, $code, $previous, $trackId);
        $this->maxAmount = $maxAmount;
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
                    'code'=> 'MAX_AMOUNT_ERROR',
                    'message'=> "Max amount {$this->maxAmount} Tomans per transaction limitation exceeded",
                ]
            ],400) : parent::render($request);
    }
}
