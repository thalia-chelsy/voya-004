@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 fw-bold">Laporan & Riwayat Inspeksi Armada - Voya-004</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daftar Laporan Temuan Fisik & Status Teknis</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal & Waktu</th>
                            <th>Kendaraan (No. Plat)</th>
                            <th>Tahapan</th>
                            <th>Status Teknis</th>
                            <th>Catatan Inspector</th>
                            <th>Petugas/Inspector</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $index => $lap)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lap['created_at'] ?? '-' }}</td>
                            <td>
                                <strong>{{ $lap['kendaraan']['nama_model'] ?? $lap['kendaraan']['nama_kendaraan'] ?? 'Kendaraan' }}</strong><br>
                                <small class="text-muted">{{ $lap['kendaraan']['nopol'] ?? $lap['kendaraan']['plat_nomor'] ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $lap['tahapan'] ?? '-' }}</span>
                            </td>
                            <td>
                                @php
                                    $status = $lap['status_teknis'] ?? 'Layak Jalan';
                                    $bg = 'bg-success';
                                    if($status == 'Perlu Perbaikan') $bg = 'bg-warning text-dark';
                                    if($status == 'Dalam Perawatan') $bg = 'bg-danger';
                                @endphp
                                <span class="badge {{ $bg }}">{{ $status }}</span>
                            </td>
                            <td>{{ $lap['catatan_inspector'] ?? '-' }}</td>
                            <td>{{ $lap['inspector']['name'] ?? 'Inspector' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data laporan inspeksi yang dikirim.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection