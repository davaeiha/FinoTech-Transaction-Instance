<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use JetBrains\PhpStorm\Pure;
use Throwable;

class FinoTechException extends Exception
{
    protected string $encryptedTrackId;

    #[Pure] public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, $trackId=null)
    {
        parent::__construct($message, $code, $previous);
        $this->encryptedTrackId = Crypt::encryptString($trackId);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
            return response()->json([
                'status'=>'Failed',
                'trackId'=>$this->encryptedTrackId,
                'error'=>[
                    'code'=>'ERROR',
                    'message'=>$this->getMessage()
                ]
            ]);
    }
}
