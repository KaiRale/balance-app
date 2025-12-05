<?php

namespace App\Services;

use App\Enums\Transaction\TransactionType;
use App\Exceptions\Transaction\TransactionException;
use App\Exceptions\User\UserNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransferService extends AbstractBalanceService
{
    /**
     * @throws TransactionException
     * @throws UserNotFoundException
     * @throws InvalidArgumentException
     */
    public function transfer(int $fromUserId, int $toUserId, float $amount, string $comment): array
    {
        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be positive');
        }

        if ($fromUserId === $toUserId) {
            throw new \InvalidArgumentException('Cannot transfer to yourself');
        }

        return DB::transaction(function () use ($fromUserId, $toUserId, $amount, $comment) {
            // Receive invoices (with user verification)
            $fromAccount = $this->getAccountForUser($fromUserId);
            $toAccount = $this->getAccountForUser($toUserId);

            // Checking the sender's balance
            if ($fromAccount->getBalanceAttribute()  < $amount) {
                throw new TransactionException('Insufficient balance');
            }

            // UUID for linking two transactions
            $batchUuid = Str::uuid();

            // Creating an outgoing transaction (from the sender)
            $outgoingTransaction = $fromAccount->balanceTransactions()->create([
                'type' => TransactionType::TRANSFER_OUT,
                'amount' => -$amount,
                'comment' => $comment,
                'batch_uuid' => $batchUuid,
                'meta' => [
                    'to_user_id' => $toUserId,
                ],
            ]);

            // Creating an incoming transaction (from the recipient)
            $incomingTransaction = $toAccount->balanceTransactions()->create([
                'type' => TransactionType::TRANSFER_IN,
                'amount' => $amount,
                'comment' => $comment,
                'batch_uuid' => $batchUuid,
                'related_transaction_id' => $outgoingTransaction->id,
                'meta' => [
                    'from_user_id' => $fromUserId,
                ],
            ]);

            // Linking transactions
            $outgoingTransaction->update([
                'related_transaction_id' => $incomingTransaction->id,
            ]);

            return [
                'outgoing_transaction' => $outgoingTransaction,
                'incoming_transaction' => $incomingTransaction,
            ];
        });
    }
}
