<?php

namespace App\Exceptions\Account;

use App\Exceptions\FinoTechException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use JetBrains\PhpStorm\Pure;

class MinAmountException extends FinoTechException
{

    protected int $minAmount;

    #[Pure] public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, $trackId=null, $minAmount)
    {
        parent::__construct($message, $code, $previous,$trackId);

        $this->minAmount = $minAmount;
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
                    'code'=> 'MIN_AMOUNT_ERROR',
                    'message'=> "Minimum amount is {$this->minAmount} Tomans.",
                ]
            ],400) : parent::render($request);
    }
}
