<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PenyewaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminTransaksiController;
use App\Http\Controllers\InspectorController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/profil', [AuthController::class, 'editProfile'])->name('profil.edit');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profil.update');

Route::get('/kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');
Route::get('/kendaraan/create', [KendaraanController::class, 'create'])->name('kendaraan.create');
Route::post('/kendaraan', [KendaraanController::class, 'store'])->name('kendaraan.store');
Route::get('/kendaraan/{id}/edit', [KendaraanController::class, 'edit'])->name('kendaraan.edit');
Route::put('/kendaraan/{id}', [KendaraanController::class, 'update'])->name('kendaraan.update');
Route::delete('/kendaraan/{id}', [KendaraanController::class, 'destroy'])->name('kendaraan.destroy');

// Pastikan menggunakan Route::get untuk halaman katalog
Route::get('/kendaraan/katalog', [PenyewaController::class, 'katalog'])->name('penyewa.katalog');

Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

    // Dashboard Admin (Role 1)
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Dashboard Petugas (Role 2)
    Route::get('/petugas/dashboard', function () {
        return view('petugas.dashboard');
    })->name('petugas.dashboard');

    // Dashboard Inspector (Role 3)
    Route::get('/inspector/dashboard', function () {
        return view('inspector.dashboard');
    })->name('inspector.dashboard');

    // Dashboard Penyewa (Role 4)
    Route::get('/penyewa/dashboard', function () {
        return view('penyewa.dashboard');
    })->name('penyewa.dashboard');

Route::get('/register', function () {
    // Pastikan file auth/register.blade.php udah kamu pindah dari server ke client ya
    return view('auth.register'); 
})->name('register');


Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
Route::get('/admin/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi.index');
Route::get('/admin/pengaduan', [AdminTransaksiController::class, 'pengaduan'])->name('admin.pengaduan.index');
Route::put('/admin/pengaduan/{id}/tanggapi', [AdminTransaksiController::class, 'prosesTanggapi'])->name('admin.pengaduan.tanggapi');
Route::get('/admin/laporan-inspeksi', [AdminTransaksiController::class, 'laporanInspeksi'])->name('admin.laporan.inspeksi');

Route::get('/petugas/transaksi', [TransaksiController::class, 'indexPetugas'])->name('petugas.transaksi.petugas_index');
Route::put('/petugas/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('transaksis.updateStatus');
Route::get('/petugas/serah-terima', [TransaksiController::class, 'indexSerahTerima'])->name('petugas.transaksi.serah_terima');
Route::get('/petugas/transaksi/{id}/serah-terima', [TransaksiController::class, 'formSerahTerima'])->name('petugas.transaksi.formSerahTerima');
Route::put('/petugas/transaksi/{id}/serah-terima', [TransaksiController::class, 'prosesSerahTerima'])->name('petugas.transaksi.serahTerima');

Route::get('/inspector/kendaraan', [InspectorController::class, 'index'])->name('inspector.index');
Route::post('/inspector/inspeksi', [InspectorController::class, 'store'])->name('inspector.store');
Route::get('/inspector/laporan', [InspectorController::class, 'laporan'])->name('inspector.laporan');

Route::get('/penyewa/pengaduan/create', [PenyewaController::class, 'createPengaduan'])->name('penyewa.pengaduan.create');
Route::post('/penyewa/pengaduan', [PenyewaController::class, 'storePengaduan'])->name('penyewa.pengaduan.store');
Route::get('/penyewa/riwayat', [PenyewaController::class, 'riwayat'])->name('penyewa.riwayat');
