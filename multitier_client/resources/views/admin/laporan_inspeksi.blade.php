@extends('layouts.app')
@section('title', 'Monitoring Laporan Inspeksi Inspector')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary-voya">Monitoring Laporan Inspeksi - Voya-004</h3>
        <div class="btn-group" role="group">
            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-primary">Pantau Transaksi</a>
            <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-primary">Laporan Pengaduan</a>
            <a href="{{ route('admin.laporan.inspeksi') }}" class="btn btn-primary active">Inspeksi Teknis</a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Waktu Inspeksi</th>
                            <th>Kendaraan & Plat</th>
                            <th>Tahapan</th>
                            <th>Status Teknis</th>
                            <th>Catatan Fisik Inspector</th>
                            <th>Petugas / Inspector</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanInspeksis as $index => $lap)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $lap['created_at'] ?? '-' }}</td>
                            <td>
                                <strong>{{ $lap['kendaraan']['nama_model'] ?? $lap['kendaraan']['nama_kendaraan'] ?? '-' }}</strong><br>
                                <small class="text-muted font-monospace">{{ $lap['kendaraan']['nopol'] ?? $lap['kendaraan']['plat_nomor'] ?? '-' }}</small>
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
                            <td colspan="7" class="text-center text-muted py-4">Belum ada laporan inspeksi teknis dari lapangan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection