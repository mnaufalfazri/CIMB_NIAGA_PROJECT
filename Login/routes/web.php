<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashAdminController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', fn () => view('auth.login'))-> name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', fn () => view('auth.register'))-> name('login');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/DashNasabah', [DashboardController::class, 'index'])->middleware('auth');

Route::group(['middleware' => ['auth', 'check_role:admin']], function(){
    Route::get('/DashAdmin', [DashAdminController::class, 'index'])->middleware('auth');
});

Route::get('/logout', [AuthController::class, 'logout']);