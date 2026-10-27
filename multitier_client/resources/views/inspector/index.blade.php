@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Panel Inspeksi Teknis Armada - Voya-004</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Tabel Daftar Kendaraan -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold">Daftar Kendaraan & Status Teknis</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kendaraan</th>
                                    <th>No. Plat</th>
                                    <th>Status Teknis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kendaraans as $k)
                                <tr>
                                    <td>{{ $k['nama_kendaraan'] ?? $k['nama_model'] ?? '-' }}</td>
                                    <td>{{ $k['nopol'] ?? '-' }}</td>
                                    <td>
                                        @php
                                            $statusTeknis = $k['kondisi_teknis'] ?? $k['status_teknis'] ?? 'Layak Jalan';
                                            $badgeBg = 'bg-success';
                                            if($statusTeknis == 'Perlu Perbaikan') $badgeBg = 'bg-warning text-dark';
                                            if($statusTeknis == 'Dalam Perawatan') $badgeBg = 'bg-danger';
                                        @endphp
                                        <span class="badge {{ $badgeBg }}">{{ $statusTeknis }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Belum ada data kendaraan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Form Input Inspeksi Fisik -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">Form Pemeriksaan Fisik & Kelayakan</div>
                <div class="card-body">
                    <form action="{{ route('inspector.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Kendaraan</label>
                            <select name="kendaraan_id" class="form-select" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($kendaraans as $k)
                                    <option value="{{ $k['id'] ?? '' }}">
                                        {{ $k['nama_kendaraan'] ?? $k['nama_model'] ?? 'Kendaraan' }} 
                                        ({{ $k['plat_nomor'] ?? $k['nopol'] ?? $k['nomor_plat'] ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tahapan Pemeriksaan</label>
                            <select name="tahapan" class="form-select" required>
                                <option value="Pre-Rental">Pre-Rental (Sebelum Disewa)</option>
                                <option value="Post-Rental">Post-Rental (Sesudah Disewa)</option>
                                <option value="Perawatan Rutin">Perawatan Rutin / Servis</option>
                            </select>
                        </div>

                        <label class="form-label fw-bold">Checklist Komponen Fisik:</label>
                        <div class="mb-3 border p-3 rounded bg-light">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="kondisi_rem" value="1" id="rem" checked>
                                <label class="form-check-label" for="rem">Sistem Pengereman (Rem) Berfungsi</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="kondisi_ban" value="1" id="ban" checked>
                                <label class="form-check-label" for="ban">Kondisi Ban (Tekanan & Alur) Baik</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="kondisi_bodi" value="1" id="bodi" checked>
                                <label class="form-check-label" for="bodi">Bodi Kendaraan (Tanpa Lecet Parah)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kondisi_mesin" value="1" id="mesin" checked>
                                <label class="form-check-label" for="mesin">Kondisi Mesin & Suara Normal</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tentukan Status Teknis</label>
                            <select name="status_teknis" class="form-select" required>
                                <option value="Layak Jalan">Layak Jalan (Aman)</option>
                                <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                                <option value="Dalam Perawatan">Dalam Perawatan (Bengkel)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan Fisik Inspector <span class="text-danger">*</span></label>
                            <textarea name="catatan_inspector" class="form-control" rows="3" placeholder="Wajib diisi hasil temuan fisik di lapangan..." required></textarea>
                            <div class="form-text text-muted">Dilarang menyatakan aman tanpa catatan hasil pemeriksaan fisik.</div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 fw-bold">Simpan Hasil Inspeksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection