<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voya-004 | @yield('title', 'Aplikasi Rental')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Kustomisasi Tema Voya-004 -->
    <style>
        :root {
            --primary-color: #1E88E5;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f4f6f9;
        }
        .navbar {
            background-color: #1E88E5 !important;
        }
        .btn-primary {
            background-color: #1E88E5 !important;
            border-color: #1E88E5 !important;
        }
        .btn-primary:hover {
            background-color: #1565C0 !important;
            border-color: #1565C0 !important;
        }
        .table thead.table-primary, 
        .table thead.bg-primary,
        .table thead {
            background-color: #1E88E5 !important;
            color: #ffffff !important;
        }
        .bg-primary-voya { background-color: var(--primary-color) !important; }
        .text-primary-voya { color: var(--primary-color) !important; }
        .btn-primary-voya { background-color: var(--primary-color); border-color: var(--primary-color); color: white; }
        .btn-primary-voya:hover { background-color: #1565C0; color: white; }
        
        main { flex: 1; } /* Agar footer selalu di bawah */
        .profile-thumb { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid white; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary-voya shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">VOYA-004</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu Sebelah Kiri -->
                <ul class="navbar-nav me-auto">
                    @if(session()->has('api_token') || session()->has('user_data'))
                        @php 
                            $userData = session('user_data') ?? session('user') ?? [];
                            $role = $userData['role_id'] ?? null; 
                        @endphp
                        
                        <!-- Menu Umum untuk semua yang login -->
                        <li class="nav-item">
                            @php
                                $dashUrl = '#';
                                if ($role == 1) $dashUrl = route('admin.dashboard');
                                elseif ($role == 2) $dashUrl = route('petugas.dashboard');
                                elseif ($role == 3) $dashUrl = route('inspector.dashboard');
                                elseif ($role == 4) $dashUrl = route('penyewa.dashboard');
                            @endphp
                            <a class="nav-link" href="{{ $dashUrl }}">Dashboard</a>
                        </li>

                        <!-- Menu khusus ADMIN (Role 1) -->
                        @if($role == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Kelola User</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('kendaraan.index') }}">Data Kendaraan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.transaksi.index') }}">Semua Laporan</a></li>
                        
                        <!-- Menu khusus PETUGAS (Role 2) -->
                        @elseif($role == 2)
                            <li class="nav-item"><a class="nav-link" href="{{ route('kendaraan.index') }}">Katalog (View)</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('petugas.transaksi.petugas_index') }}">Persetujuan Sewa</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('petugas.transaksi.serah_terima') }}">Serah Terima</a></li>

                        <!-- Menu khusus INSPECTOR (Role 3) -->
                        @elseif($role == 3)
                            <li class="nav-item"><a class="nav-link" href="{{ route('inspector.index') }}">Kondisi Armada</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('inspector.laporan') }}">Laporan Inspeksi</a></li>

                        <!-- Menu khusus PENYEWA (Role 4) -->
                        @elseif($role == 4)
                            <li class="nav-item"><a class="nav-link" href="{{ route('penyewa.katalog') }}">Katalog Kendaraan</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('penyewa.riwayat') }}">Riwayat Sewa Saya</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('penyewa.pengaduan.create') }}">Form Pengaduan</a></li>
                        @endif
                    @endif
                </ul>

                <!-- Menu Sebelah Kanan (Tombol Login/Logout & Profil) -->
                <ul class="navbar-nav ms-auto">
                    @if(!session()->has('api_token') && !session()->has('user_data'))
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- Menampilkan nama user yang sedang login dari session -->
                                {{ $userData['nama_lengkap'] ?? 'Akun Saya' }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="navbarDropdown">
                                <!-- Tautan ke Halaman Pengaturan Profil -->
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profil.edit') }}">
                                        <i class="bi bi-gear-fill me-2"></i> Pengaturan Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <!-- Tombol Logout -->
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="container-fluid py-4">
        @yield('content')
    </main>

    <!-- Footer Wajib Sesuai Ketentuan -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">&copy; 2026 Thalia Chelsy Vivian - 25.K3.0004</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>