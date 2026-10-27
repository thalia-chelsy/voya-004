@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    Formulir Serah Terima Kendaraan - Voya-004
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <h5 class="text-secondary mb-3">Detail Transaksi #{{ $transaksi['id'] ?? '-' }}</h5>
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th width="35%">Penyewa</th>
                            <td>{{ $transaksi['user']['nama_lengkap'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kendaraan</th>
                            <td>{{ $transaksi['kendaraan']['nama_model'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jadwal Sewa</th>
                            <td>{{ $transaksi['tgl_mulai'] ?? '-' }} s/d {{ $transaksi['tgl_rencana_kembali'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Saat Ini</th>
                            <td><span class="badge bg-warning text-dark">{{ $transaksi['status'] ?? '-' }}</span></td>
                        </tr>
                    </table>

                    <!-- Form Aksi Berdasarkan Status -->
                    <form action="{{ route('petugas.transaksi.serahTerima', $transaksi['id'] ?? 0) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if(($transaksi['status'] ?? '') == 'Disetujui')
                            <input type="hidden" name="aksi" value="check_out">
                            <div class="alert alert-info">
                                <strong>Check-Out:</strong> Memulai masa peminjaman dan menyerahkan kunci mobil kepada penyewa.
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold" onclick="return confirm('Konfirmasi serahkan kendaraan?')">Proses Check-Out (Mobil Keluar)</button>
                        
                        @elseif(($transaksi['status'] ?? '') == 'Sedang Disewa')
                            <input type="hidden" name="aksi" value="check_in">
                            <div class="alert alert-success">
                                <strong>Check-In:</strong> Menerima pengembalian kendaraan dan menghitung potensi denda keterlambatan secara otomatis.
                            </div>
                            <button type="submit" class="btn btn-success w-100 fw-bold" onclick="return confirm('Konfirmasi pengembalian kendaraan?')">Proses Check-In (Mobil Masuk & Hitung Denda)</button>
                        
                        @else
                            <div class="alert alert-secondary text-center">
                                Transaksi ini sudah selesai atau tidak memerlukan tindakan serah terima saat ini.
                            </div>
                        @endif
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('petugas.transaksi.petugas_index') }}" class="text-decoration-none">← Kembali ke Daftar Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection