<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Transaction\TransactionException;
use App\Exceptions\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use Illuminate\Http\JsonResponse;

class TransferController extends Controller
{
    public function __construct(private TransferService $transferService)
    {
    }

    public function store(TransferRequest $request): JsonResponse
    {
        try {
            $result = $this->transferService->transfer(
                $request->from_user_id,
                $request->to_user_id,
                (float) $request->amount,
                $request->comment ?? ''
            );

            return response()->json([
                'message' => 'Transfer successful',
                'batch_uuid' => $result['outgoing_transaction']->batch_uuid,
                'from_balance' => $result['outgoing_transaction']->account->balance,
                'to_balance' => $result['incoming_transaction']->account->balance,
            ], 200);

        } catch (TransactionException|UserNotFoundException $e) {
            return $e->render();
        }
    }
}
