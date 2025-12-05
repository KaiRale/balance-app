<?php

namespace App\Services;

use App\Exceptions\User\UserNotFoundException;
use App\Models\Account;
use App\Repositories\AccountRepository;

abstract class AbstractBalanceService
{
    protected AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @throws UserNotFoundException
     */
    protected function getAccountForUser(int $userId): Account
    {
        return $this->accountRepository->findOrCreateForUser($userId);
    }

    protected function findAccount(int $userId): ?Account
    {
        return $this->accountRepository->findForUser($userId);
    }
}
