<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\User\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\BalanceService;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    public function __construct(private BalanceService $balanceService)
    {
    }

    /**
     * @throws UserNotFoundException
     */
    public function show(int $userId): JsonResponse
    {
        $balance = $this->balanceService->getBalance($userId);

        return response()->json($balance);
    }
}
