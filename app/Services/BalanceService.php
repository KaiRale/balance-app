<?php

namespace App\Services;

use App\Exceptions\User\UserNotFoundException;

class BalanceService extends AbstractBalanceService
{
    public function getBalance(int $userId): array
    {
        $account = $this->findAccount($userId);

        return [
            'user_id' => $userId,
            'balance' => $account?->balance ?? 0.00
        ];
    }
}
