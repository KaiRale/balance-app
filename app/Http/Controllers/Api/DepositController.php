<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepositRequest;
use App\Services\DepositService;
use Illuminate\Http\JsonResponse;

class DepositController extends Controller
{
    public function __construct(private DepositService $depositService)
    {
    }

    public function store(DepositRequest $request): JsonResponse
    {
        try {
            $transaction = $this->depositService->deposit(
                $request->user_id,
                (float) $request->amount,
                $request->comment ?? ''
            );

            return response()->json([
                'message' => 'Deposit successful',
                'transaction_id' => $transaction->id,
                'balance' => $transaction->account->balance,
            ], 201);

        } catch (UserNotFoundException $e) {
            return $e->render();
        }
    }
}
