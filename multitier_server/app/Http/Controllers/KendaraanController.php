<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Services\KendaraanService;
use Exception;

class KendaraanController extends Controller
{
    protected $kendaraanService;

    // Inject Service Layer
    public function __construct(KendaraanService $kendaraanService)
    {
        $this->kendaraanService = $kendaraanService;
    }

    // Menampilkan daftar kendaraan (API)
    public function index(Request $request)
    {
        $query = Kendaraan::query();
        
        // Fitur Pencarian
        if ($request->has('cari') && $request->cari != '') {
            $query->where('nama_model', 'like', '%' . $request->cari . '%')
                  ->orWhere('nopol', 'like', '%' . $request->cari . '%');
        }
        
        // Pagination (10 data per halaman)
        $kendaraan = $query->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'pesan' => 'Data kendaraan berhasil diambil',
            'data' => $kendaraan
        ], 200);
    }

    // Menyimpan data ke database beserta foto (API)
    public function store(Request $request)
    {
        $request->validate([
            'nopol' => 'required|unique:t004_kendaraan,nopol',
            'nama_model' => 'required|string|max:100',
            'merek' => 'required|string|max:50',
            'kategori' => 'required|string|max:50',
            'tahun' => 'required|integer',
            'warna' => 'required|string|max:30',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'kondisi_teknis' => 'required',
            'status_ketersediaan' => 'required',
            'foto_kendaraan' => 'nullable|image|mimes:jpg,jpeg,png|max:2048' // Validasi gambar max 2MB
        ]);

        try {
            // Panggil Service untuk memproses upload dan insert DB
            $kendaraan = $this->kendaraanService->tambahKendaraan(
                $request->except('foto_kendaraan'),
                $request->file('foto_kendaraan')
            );

            return response()->json([
                'status' => 'success',
                'pesan' => 'Data kendaraan berhasil ditambahkan!',
                'data' => $kendaraan
            ], 201);
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan' => $e->getMessage()
            ], 400);
        }
    }

    // Menampilkan katalog kendaraan untuk Penyewa (API)
    public function katalog(Request $request)
    {
        // Pastikan kolom is_aktif ada di DB Anda, atau ganti dengan status_ketersediaan
        $query = Kendaraan::where('status_ketersediaan', '!=', 'Tidak Tersedia');

        // Filter pencarian
        if ($request->has('cari') && $request->cari != '') {
            $query->where('nama_model', 'like', '%' . $request->cari . '%')
                  ->orWhere('merek', 'like', '%' . $request->cari . '%');
        }

        $kendaraan = $query->paginate(9);
        
        return response()->json([
            'status' => 'success',
            'pesan' => 'Katalog kendaraan berhasil diambil',
            'data' => $kendaraan
        ], 200);
    }
}