<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\PaymentController;

Route::middleware(['validate.token'])->group(function () {
    Route::get('/transfer', [TransferController::class, 'create'])->name('transfer.create');
    Route::post('/transfer/validate-account', [TransferController::class, 'validateAccount'])->name('transfer.validate-account');
    Route::post('/transfer/confirm', [TransferController::class, 'confirm'])->name('transfer.confirm');
    Route::post('/transfer/execute', [TransferController::class, 'execute'])->name('transfer.execute');
    Route::get('/transfer/receipt/{id}', [TransferController::class, 'receipt'])->name('transfer.receipt');
    Route::get('/transfer/history', [TransferController::class, 'history'])->name('transfer.history');
    
    Route::get('/payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/check-bill', [PaymentController::class, 'checkBill'])->name('payment.check-bill');
    Route::post('/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
    Route::post('/payment/execute', [PaymentController::class, 'execute'])->name('payment.execute');
    Route::get('/payment/receipt/{id}', [PaymentController::class, 'receipt'])->name('payment.receipt');
    Route::get('/payment/history', [PaymentController::class, 'history'])->name('payment.history');
});

Route::get('/', function () {
    return redirect()->route('transfer.create');
});
