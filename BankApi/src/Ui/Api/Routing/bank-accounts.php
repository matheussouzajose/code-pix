<?php

use App\Http\Controllers\Api\BankAccount\BankAccountController;
use App\Http\Controllers\Api\BankAccount\PixKeyController;
use App\Http\Controllers\Api\BankAccount\TransactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'bank-accounts'], function () {
    Route::get('/{id}', [BankAccountController::class, 'show']);
    Route::get('/', [BankAccountController::class, 'index']);

    Route::get('/{id}/pix-keys', [PixKeyController::class, 'index']);
    Route::post('/{id}/pix-keys', [PixKeyController::class, 'store']);
    Route::get('/{id}/pix-keys/{kind}/{key}/exists', [PixKeyController::class, 'exist']);

    Route::get('/{id}/transactions', [TransactionController::class, 'index']);
    Route::post('/{id}/transactions', [TransactionController::class, 'store']);
});
