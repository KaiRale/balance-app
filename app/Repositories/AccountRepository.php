<?php

namespace App\Repositories;

use App\Exceptions\User\UserNotFoundException;
use App\Models\Account;
use App\Models\User;

class AccountRepository
{
    /**
     * Find the user's account
     */
    public function findForUser(int $userId): ?Account
    {
        return Account::where('user_id', $userId)->first();
    }

    /**
     * Create an account for an existing user
     * @throws UserNotFoundException
     */
    public function createForUser(int $userId): Account
    {
        if (!User::where('id', $userId)->exists()) {
            throw new UserNotFoundException();
        }

        return Account::create([
            'user_id' => $userId,
            'currency' => 'RUB'
        ]);
    }

    /**
     * Find or create an account
     * @throws UserNotFoundException
     */
    public function findOrCreateForUser(int $userId): Account
    {
        $account = $this->findForUser($userId);

        if (!$account) {
            $account = $this->createForUser($userId);
        }

        return $account;
    }
}
