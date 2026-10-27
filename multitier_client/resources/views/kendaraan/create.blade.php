@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Kendaraan Baru</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('kendaraan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Merek</label>
                            <input type="text" name="merek" class="form-control" required placeholder="Contoh: Toyota">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Model</label>
                            <input type="text" name="nama_model" class="form-control" required placeholder="Contoh: Avanza Veloz">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Plat (Nopol)</label>
                            <input type="text" name="nopol" class="form-control" required placeholder="Contoh: H1121AB">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Mobil">Mobil</option>
                                <option value="Motor">Motor</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun</label>
                                <input type="number" name="tahun" class="form-control" required placeholder="2023">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Warna</label>
                                <input type="text" name="warna" class="form-control" required placeholder="Hitam">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga Sewa per Hari (Rp)</label>
                            <input type="number" name="harga_sewa_per_hari" class="form-control" required placeholder="350000">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Ketersediaan</label>
                            <select name="status_ketersediaan" class="form-select" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kondisi Teknis</label>
                            <select name="kondisi_teknis" class="form-select" required>
                                <option value="Layak Digunakan">Layak Digunakan</option>
                                <option value="Perlu Pemeriksaan">Perlu Pemeriksaan</option>
                                <option value="Dalam Perawatan">Dalam Perawatan</option>
                                <option value="Tidak Layak Jalan">Tidak Layak Jalan</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kendaraan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Kendaraan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection