@extends('layouts.app')
@section('title', 'Pantau Transaksi & Inspeksi')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary-voya mb-4">Pantau Transaksi & Laporan Inspeksi Voya-004</h3>
        <div class="btn-group" role="group">
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary active">Pantau Transaksi</a>
                <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-primary">Laporan Pengaduan</a>
                <a href="{{ route('admin.laporan.inspeksi') }}" class="btn btn-outline-primary">Inspeksi Teknis</a>
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
                            <th>Penyewa</th>
                            <th>Kendaraan</th>
                            <th>Tanggal Sewa</th>
                            <th>Status Sewa</th>
                            <th>Laporan Inspeksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $index => $t)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $t['penyewa']['nama_lengkap'] ?? '-' }}</td>
                                <td>{{ $t['kendaraan']['nama_model'] ?? '-' }}</td>
                                <td>{{ $t['tgl_mulai'] ?? '-' }} s/d {{ $t['tgl_rencana_kembali'] ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">{{ $t['status'] ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">Belum Inspeksi</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection