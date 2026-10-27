@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 fw-bold">Riwayat Penyewaan Kendaraan - Voya-004</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Transaksi & Rental Anda</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kendaraan & Plat</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Total Biaya</th>
                            <th>Status Rental</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayats as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <!-- Sesuaikan dengan kolom kendaraan Anda (nama_model / nama_kendaraan) -->
                                <strong>{{ $r['kendaraan']['nama_model'] ?? $r['kendaraan']['nama_kendaraan'] ?? 'Kendaraan' }}</strong><br>
                                <small class="text-muted font-monospace">{{ $r['kendaraan']['nopol'] ?? $r['kendaraan']['plat_nomor'] ?? '-' }}</small>
                            </td>
                            <td>{{ $r['tanggal_mulai'] ?? $r['tgl_mulai'] ?? '-' }}</td>
                            <td>{{ $r['tanggal_selesai'] ?? $r['tgl_selesai'] ?? '-' }}</td>
                            <td>Rp {{ number_format($r['total_biaya'] ?? $r['biaya'] ?? 0, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $status = $r['status_rental'] ?? $r['status'] ?? 'Aktif';
                                    $badge = 'bg-success';
                                    if($status == 'Pending') $badge = 'bg-warning text-dark';
                                    if($status == 'Selesai') $badge = 'bg-secondary';
                                @endphp
                                <span class="badge {{ $badge }}">{{ $status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('penyewa.pengaduan.create') }}" class="btn btn-sm btn-outline-danger">
                                    Laporkan
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat penyewaan kendaraan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection