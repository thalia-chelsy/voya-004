<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

// Rute yang dilindungi auth dan middleware role
Route::middleware(['auth'])->group(function () {
    // Semua role yang login bisa masuk dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Modul Kendaraan (Admin & Inspector)
    Route::middleware(['role:Admin,Inspector'])->group(function () {
        Route::resource('kendaraan', KendaraanController::class);
    });

    Route::middleware(['role:Penyewa'])->group(function () {
        Route::get('/katalog', [KendaraanController::class, 'katalog'])->name('penyewa.katalog');    
        Route::post('/sewa/ajukan', [TransaksiController::class, 'store'])->name('transaksi.store');
    });

    // Modul Operasional Petugas & Admin
    Route::middleware(['role:Admin,Petugas'])->group(function () {
        Route::get('/operasional/transaksi', [TransaksiController::class, 'indexPetugas'])->name('transaksi.petugas');
        Route::patch('/operasional/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
    });
});