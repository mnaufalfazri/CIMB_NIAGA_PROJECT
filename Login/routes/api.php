<?php

use App\Http\Controllers\InternalApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Login (Regist) Service
|--------------------------------------------------------------------------
|
| Internal routes diproteksi oleh InternalSecretMiddleware (X-Internal-Secret).
| validate-token juga membutuhkan auth:sanctum untuk verifikasi token.
|
*/

// --- Auth API (tanpa internal secret, untuk login dari service lain) ---
Route::post('/auth/login', [InternalApiController::class, 'login']);

// --- Internal Service-to-Service Routes (hanya boleh dipanggil antar service) ---
Route::middleware(['internal.secret'])->prefix('internal')->group(function () {

    // Token validation: dipanggil oleh Transfer/Payment service
    // GET /api/internal/validate-token
    // Header: Authorization: Bearer {sanctum_token}
    Route::middleware('auth:sanctum')->get('/validate-token', [InternalApiController::class, 'validateToken']);

    // User lookup by nomor rekening: dipanggil oleh service lain
    // GET /api/internal/user-by-rekening/{nomor_rekening}
    Route::get('/user-by-rekening/{nomor_rekening}', [InternalApiController::class, 'userByRekening']);
});
