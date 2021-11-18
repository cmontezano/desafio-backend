<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
});
