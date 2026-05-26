<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MutasiController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['validate.token'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');

    // Wealth Management & Mutasi
    Route::get('/wealth/dashboard', [DashboardController::class, 'index'])->name('wealth.dashboard');
    Route::get('/wealth/mutasi', [MutasiController::class, 'index'])->name('wealth.mutasi');
});

require __DIR__.'/settings.php';