<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Pastikan baris ini ada

// Route untuk Login (Tamu)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Route untuk Admin (Harus Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 1. Dashboard Utama (Menggunakan Controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Detail Transaksi (Route Baru)
    Route::get('/dashboard/transaction/{id}', [DashboardController::class, 'showTransaction'])->name('dashboard.transaction.detail');
});

Route::get('/', function () {
    return redirect('/login');
});
