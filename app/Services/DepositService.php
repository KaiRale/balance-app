<?php

namespace App\Services;

use App\Enums\Transaction\TransactionType;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\DB;

class DepositService extends AbstractBalanceService
{
    public function deposit(int $userId, float $amount, string $comment): BalanceTransaction
    {
        // Validation of the amount one more time
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        return DB::transaction(function () use ($userId, $amount, $comment) {
            $account = $this->getAccountForUser($userId);

            return $account->balanceTransactions()->create([
                'type' => TransactionType::DEPOSIT,
                'amount' => $amount,
                'comment' => $comment,
                'meta' => [
                    'created_at' => now()->toISOString(),
                ]
            ]);
        });
    }
}
