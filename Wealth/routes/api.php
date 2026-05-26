<?php

use App\Http\Controllers\Internal\AccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Internal API Routes — Wealth Management & Mutasi Microservice
|--------------------------------------------------------------------------
|
| These routes are intended for internal service-to-service communication.
| They are protected by the InternalApiMiddleware which validates the
| X-Internal-Api-Key header against the INTERNAL_API_KEY env variable.
|
*/

Route::prefix('internal')
    ->middleware('internal.api')
    ->group(function () {
        // SRS-BNK-003: Auto-create account (called by Registration Service)
        Route::post('/accounts', [AccountController::class, 'store']);

        // SRS-BNK-004: Check balance
        Route::get('/balance/{nomor_rekening}', [AccountController::class, 'balance']);

        // SRS-BNK-005: Validate account existence
        Route::get('/validate-account/{nomor_rekening}', [AccountController::class, 'validate']);

        // SRS-BNK-006: Debit account (called by Transfer & Payment Service)
        Route::post('/debit', [AccountController::class, 'debit']);

        // SRS-BNK-007: Credit account (called by Transfer & Payment Service)
        Route::post('/credit', [AccountController::class, 'credit']);
    });
