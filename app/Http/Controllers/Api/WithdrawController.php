<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Transaction\TransactionException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\WithdrawRequest;
use App\Services\WithdrawService;
use Illuminate\Http\JsonResponse;

class WithdrawController extends Controller
{
    public function __construct(private WithdrawService $withdrawService)
    {
    }

    public function store(WithdrawRequest $request): JsonResponse
    {
        try {
            $transaction = $this->withdrawService->withdraw(
                $request->user_id,
                (float) $request->amount,
                $request->comment ?? ''
            );

            return response()->json([
                'message' => 'Withdrawal successful',
                'transaction_id' => $transaction->id,
                'balance' => $transaction->account->balance,
            ], 200);

        } catch (TransactionException|UserNotFoundException $e) {
            return $e->render();
        }
    }
}
