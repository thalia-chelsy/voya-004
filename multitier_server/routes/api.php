<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IdentitasController;
use App\Http\Controllers\Api\KendaraanApiController;
use App\Http\Controllers\Api\TransaksiApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminTransaksiController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\TransaksiController;

// ==========================================
// 1. RUTE PUBLIK (Tidak perlu token / login)
// ==========================================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']); // Jika ada register
Route::get('/identitas', [IdentitasController::class, 'index']);

// Katalog Kendaraan Publik (Bisa diakses tanpa token jika ingin dilihat umum)
Route::get('/kendaraan', [KendaraanApiController::class, 'index']);
Route::get('/kendaraan/{id}', [KendaraanApiController::class, 'show']);


// ==========================================
// 2. RUTE PROTEKSI (Wajib menggunakan Bearer Token)
// ==========================================
Route::middleware('auth:sanctum')->group(function () {
    
    // User Profil
    Route::get('/user/profil', [UserController::class, 'showProfile']);
    Route::put('/user/profil', [UserController::class, 'updateProfile']);

    // Kendaraan (Create, Update, Delete khusus Admin/Petugas)
    Route::post('/kendaraan', [KendaraanApiController::class, 'store']);
    Route::put('/kendaraan/{id}', [KendaraanApiController::class, 'update']);
    Route::delete('/kendaraan/{id}', [KendaraanApiController::class, 'destroy']);

    // Riwayat Transaksi / Penyewaan sesuai permintaan
    Route::get('/riwayat', [TransaksiApiController::class, 'riwayat']);
    Route::get('/penyewa/riwayat-sewa', [PenyewaController::class, 'riwayatSewa']);

    // Transaksi Sewa (Penyewa mengajukan sewa)
    Route::post('/transaksi', [TransaksiController::class, 'store']);

    // Admin Routes
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::put('/admin/users/{id}', [UserController::class, 'update']);
    Route::get('/admin/transaksi', [AdminTransaksiController::class, 'index']);
    Route::get('/admin/pengaduan', [PengaduanController::class, 'pengaduanAdmin']);
    Route::put('/admin/pengaduan/{id}/tanggapi', [PengaduanController::class, 'tanggapi']);
    Route::get('/admin/laporan-inspeksi', [InspectorController::class, 'getLaporan']);

    // Petugas Routes
    Route::get('/petugas/transaksi', [PetugasController::class, 'getTransaksi']);
    Route::get('/petugas/transaksi/{id}', [PetugasController::class, 'detailTransaksi']);
    Route::put('/petugas/transaksi/{id}/status', [PetugasController::class, 'updateStatus']);
    Route::match(['POST', 'PUT'], '/petugas/transaksi/{id}/serah-terima', [PetugasController::class, 'serahTerima']);

    // Inspector Routes
    Route::get('/inspector/kendaraan', [InspectorController::class, 'indexKendaraan']);
    Route::post('/inspector/inspeksi', [InspectorController::class, 'storeInspeksi']);
    Route::get('/inspector/laporan', [InspectorController::class, 'getLaporan']);

    // Pengaduan
    Route::post('/penyewa/pengaduan', [PengaduanController::class, 'store']);
});