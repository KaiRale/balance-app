<?php

namespace App\Services;

use App\Enums\Transaction\TransactionType;
use App\Exceptions\Transaction\TransactionException;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\DB;

class WithdrawService extends AbstractBalanceService
{

    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function withdraw(int $userId, float $amount, string $comment): BalanceTransaction
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        return DB::transaction(function () use ($userId, $amount, $comment) {
            $account = $this->getAccountForUser($userId);

            // Checking if there are enough funds
            if ($account->balance < $amount) {
                throw new TransactionException('Insufficient balance');
            }

            return $account->balanceTransactions()->create([
                'type' => TransactionType::WITHDRAW,
                'amount' => -$amount, // Negative value for ease of summation
                'comment' => $comment,
            ]);
        });
    }
}
