<?php

use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\Api\DepositController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\TransferController;
use Illuminate\Support\Facades\Route;

Route::middleware('api.auth')->group(function () {
    Route::get('/balance/{user_id}', [BalanceController::class, 'show'])
        ->where('user_id', '[0-9]+');

    Route::post('/deposit', [DepositController::class, 'store']);
    Route::post('/withdraw', [WithdrawController::class, 'store']);
    Route::post('/transfer', [TransferController::class, 'store']);
});
