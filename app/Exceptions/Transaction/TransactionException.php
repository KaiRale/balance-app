<?php

namespace App\Exceptions\Transaction;

use Exception;
use Illuminate\Http\JsonResponse;

class TransactionException extends Exception
{
    public function __construct(string $message = 'Transaction error')
    {
        parent::__construct($message, 409);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
            'code' => 'transaction_error'
        ], $this->getCode());
    }
}

