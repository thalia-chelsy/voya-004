@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Form Pengaduan Kendaraan Tidak Sesuai Katalog</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('penyewa.pengaduan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Kendaraan yang Disewa</label>
                            <select name="kendaraan_id" class="form-select" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                <!-- Loop data kendaraan yang sedang disewa oleh user -->
                                @foreach($kendaraans ?? [] as $k)
                                    <option value="{{ $k['id'] }}">{{ $k['nama_model'] ?? $k['nama_kendaraan'] }} ({{ $k['nopol'] ?? $k['plat_nomor'] }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Detail Ketidaksesuaian / Keluhan</label>
                            <textarea name="isi_pengaduan" class="form-control" rows="5" placeholder="Jelaskan bagian mana yang tidak sesuai dengan katalog (misal: kondisi bodi lecet parah, AC tidak dingin, dll)..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Kirim Pengaduan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection