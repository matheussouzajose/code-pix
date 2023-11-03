<?php

use App\Http\Controllers\Api\PixKeyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pix-keys'], function () {
    Route::post('/', [PixKeyController::class, 'store']);
    Route::get('/{kind}/{key}', [PixKeyController::class, 'find']);
});
