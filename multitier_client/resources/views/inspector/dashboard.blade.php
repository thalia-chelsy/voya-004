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
    <div class="p-5 mb-4 bg-secondary text-white rounded-3 shadow-lg border-bottom border-info border-4">
        <div class="container-fluid py-3">
            <span class="badge bg-info text-dark mb-2 px-3 py-2 text-uppercase fw-bold tracking-wider">Level 3 • Inspektor Kelayakan</span>
            <h1 class="display-5 fw-bold">Dashboard Inspector Voya-004</h1>
            <p class="col-md-8 fs-5 text-light opacity-75">Panel audit teknis armada, pemeriksaan mesin, kelayakan rem/ban, dan penjadwalan perawatan berkala.</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm border-start border-success border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Layak Jalan</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-shield-alt text-success me-2"></i> 13 Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm border-start border-warning border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Perlu Pemeriksaan</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-tools text-warning me-2"></i> 1 Unit</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-white border-0 shadow-sm border-start border-danger border-4 py-2">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase fs-7 fw-bold">Dalam Perawatan</h6>
                    <h3 class="fw-bold text-dark mb-0"><i class="fas fa-oil-can text-danger me-2"></i> 0 Unit</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcuts -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-info text-dark rounded p-3 d-inline-block mb-3"><i class="fas fa-clipboard-check fa-2x"></i></div>
                        <h4 class="fw-bold">Audit Kondisi Armada</h4>
                        <p class="text-muted">Periksa status teknis setiap mobil dan motor secara berkala sebelum disewakan kembali.</p>
                    </div>
                    <a href="{{ route('inspector.index') }}" class="btn btn-outline-info text-dark fw-semibold mt-3">Mulai Inspeksi <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="bg-secondary text-white rounded p-3 d-inline-block mb-3"><i class="fas fa-wrench fa-2x"></i></div>
                        <h4 class="fw-bold">Laporan Inspeksi</h4>
                        <p class="text-muted">Lihat dan kelola laporan inspeksi kondisi armada secara terpusat.</p>
                    </div>
                    <a href="{{ route('inspector.laporan') }}" class="btn btn-outline-secondary fw-semibold mt-3">Lihat Laporan <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection