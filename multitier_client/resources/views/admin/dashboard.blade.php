@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0 mb-4 bg-white">
    <div class="card-body d-flex align-items-center">
        <!-- Foto Profil -->
        <div class="me-4">
            @if(!empty(session('user_data')['foto_profil']))
                <img src="{{ env('API_BASE_URL_ASSET', 'http://127.0.0.1:8000') . '/' . session('user_data')['foto_profil'] }}" 
                     alt="Foto Profil" class="rounded-circle shadow-sm" width="90" height="90" style="object-fit: cover;">
            @else
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 90px; height: 90px; font-size: 35px;">
                    {{ substr(session('user_data')['nama_lengkap'] ?? 'U', 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Nama dan Level Pengguna -->
        <div>
            <h4 class="fw-bold mb-1 text-dark">{{ session('user_data')['nama_lengkap'] ?? 'Pengguna' }}</h4>
            <p class="text-muted mb-2">Email: {{ session('user_data')['email'] ?? '-' }}</p>
            <div>
                <!-- Menampilkan Level / Role Pengguna -->
                <span class="badge bg-success px-3 py-2">
                    Level: 
                    @php $roleId = session('user_data')['role_id'] ?? 1; @endphp
                    @if($roleId == 1) Admin 
                    @elseif($roleId == 2) Petugas 
                    @elseif($roleId == 3) Inspector 
                    @else Penyewa 
                    @endif
                </span>
            </div>
        </div>

        <!-- Tombol Menuju Pengaturan Profil -->
        <div class="ms-auto">
            <a href="{{ route('profil.edit') }}" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-gear-fill"></i> Pengaturan Profil
            </a>
        </div>
    </div>
</div>
    <!-- Header sambutan ala kokpit otomotif -->
    <div class="p-5 mb-4 bg-dark text-white rounded-3 shadow-lg border-bottom border-danger border-4">
        <div class="container-fluid py-3">
            <span class="badge bg-danger mb-2 px-3 py-2 text-uppercase fw-bold tracking-wider">Level 1 • Administrator Utama</span>
            <h1 class="display-5 fw-bold">Dashboard Admin Voya-004</h1>
            <p class="col-md-8 fs-5 text-light opacity-75">Kontrol penuh sistem manajemen rental kendaraan, kelola data master, pantau pengguna, dan rekapitulasi laporan operasional.</p>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-white border-0 shadow-sm border-start border-primary border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Total Armada</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-car text-primary me-2"></i> 14 Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white border-0 shadow-sm border-start border-success border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Armada Tersedia</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-check-circle text-success me-2"></i> 12 Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white border-0 shadow-sm border-start border-warning border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Total Pengguna</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-users text-warning me-2"></i> 28 Akun</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white border-0 shadow-sm border-start border-danger border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Status Sistem</h6>
                    <h3 class="fw-bold text-success mb-0"><i class="fas fa-server me-2"></i> Optimal</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Shortcuts -->
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-primary text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-car-side fa-2x"></i></div>
                        <h4 class="fw-bold">Manajemen Kendaraan</h4>
                        <p class="text-muted">Kelola katalog lengkap mobil dan motor, tambah unit baru, ubah harga, atau hapus armada.</p>
                    </div>
                    <a href="{{ route('kendaraan.index') }}" class="btn btn-outline-primary fw-semibold mt-3">Kelola Katalog <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-danger text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-users-cog fa-2x"></i></div>
                        <h4 class="fw-bold">Kelola Pengguna</h4>
                        <p class="text-muted">Atur hak akses akun, verifikasi petugas baru, dan pantau aktivitas penyewa.</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger fw-semibold mt-3">Buka Panel User <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-dark text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-chart-line fa-2x"></i></div>
                        <h4 class="fw-bold">Laporan & Statistik</h4>
                        <p class="text-muted">Unduh rekapitulasi pendapatan sewa, statistik frekuensi penggunaan kendaraan.</p>
                    </div>
                    <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-dark fw-semibold mt-3">Lihat Laporan <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection