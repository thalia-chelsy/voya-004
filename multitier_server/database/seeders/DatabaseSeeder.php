<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Kendaraan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('t004_roles')->insert([
            ['id' => 1, 'nama_role' => 'Admin'],
            ['id' => 2, 'nama_role' => 'Petugas'],
            ['id' => 3, 'nama_role' => 'Inspector'],
            ['id' => 4, 'nama_role' => 'Penyewa'],
        ]);

        // 1. Admin
        User::create([
            'role_id'      => 1,
            'username'     => '25.K3.0004',
            'nama_lengkap' => 'Thalia Chelsy Vivian',
            'email'        => 'thalia@admin.com',
            'password'     => Hash::make('password123'),
            'foto_profil'  => null,
            'status_akun'  => 'Aktif'
        ]);

        // 2. Petugas
        User::create([
            'role_id'      => 2,
            'username'     => 'petugas_budi',
            'nama_lengkap' => 'Budi Petugas Operasional',
            'email'        => 'budi@petugas.com',
            'password'     => Hash::make('password123'),
            'foto_profil'  => null,
            'status_akun'  => 'Aktif'
        ]);

        // 3. Inspector
        User::create([
            'role_id'      => 3,
            'username'     => 'inspector_citra',
            'nama_lengkap' => 'Citra Inspeksi Mesin',
            'email'        => 'citra@inspector.com',
            'password'     => Hash::make('password123'),
            'foto_profil'  => null,
            'status_akun'  => 'Aktif'
        ]);

        // 4. Penyewa
        User::create([
            'role_id'      => 4,
            'username'     => 'deni_sewa',
            'nama_lengkap' => 'Deni Pelanggan Setia',
            'email'        => 'deni@penyewa.com',
            'password'     => Hash::make('password123'),
            'foto_profil'  => null,
            'status_akun'  => 'Aktif'
        ]);
    


        // 3. Masukkan 14 Data Dummy Kendaraan Sesuai Kolom Migrasi
        \DB::table('t004_kendaraan')->insert([
            [
                'nopol' => 'H1121AB',
                'nama_model' => 'Avanza Veloz',
                'merek' => 'Toyota',
                'kategori' => 'Mobil',
                'tahun' => 2022,
                'warna' => 'Putih',
                'harga_sewa_per_hari' => 350000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H2232CD',
                'nama_model' => 'Brio Satya',
                'merek' => 'Honda',
                'kategori' => 'Mobil',
                'tahun' => 2023,
                'warna' => 'Merah',
                'harga_sewa_per_hari' => 275000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H3343EF',
                'nama_model' => 'Innova Reborn',
                'merek' => 'Toyota',
                'kategori' => 'Mobil',
                'tahun' => 2021,
                'warna' => 'Hitam',
                'harga_sewa_per_hari' => 550000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H4454GH',
                'nama_model' => 'Xenia',
                'merek' => 'Daihatsu',
                'kategori' => 'Mobil',
                'tahun' => 2020,
                'warna' => 'Silver',
                'harga_sewa_per_hari' => 300000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H5565IJ',
                'nama_model' => 'Civic Turbo',
                'merek' => 'Honda',
                'kategori' => 'Mobil',
                'tahun' => 2022,
                'warna' => 'Abu-abu',
                'harga_sewa_per_hari' => 850000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H6676KL',
                'nama_model' => 'Pajero Sport',
                'merek' => 'Mitsubishi',
                'kategori' => 'Mobil',
                'tahun' => 2023,
                'warna' => 'Putih',
                'harga_sewa_per_hari' => 1100000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H7787MN',
                'nama_model' => 'Fortuner GR',
                'merek' => 'Toyota',
                'kategori' => 'Mobil',
                'tahun' => 2023,
                'warna' => 'Hitam',
                'harga_sewa_per_hari' => 1200000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H8898OP',
                'nama_model' => 'Ertiga Hybrid',
                'merek' => 'Suzuki',
                'kategori' => 'Mobil',
                'tahun' => 2022,
                'warna' => 'Biru',
                'harga_sewa_per_hari' => 350000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H1001AA',
                'nama_model' => 'Beat Street',
                'merek' => 'Honda',
                'kategori' => 'Motor',
                'tahun' => 2022,
                'warna' => 'Hitam',
                'harga_sewa_per_hari' => 90000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H2002BB',
                'nama_model' => 'NMAX 155',
                'merek' => 'Yamaha',
                'kategori' => 'Motor',
                'tahun' => 2023,
                'warna' => 'Matte Blue',
                'harga_sewa_per_hari' => 130000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H3003CC',
                'nama_model' => 'PCX 160',
                'merek' => 'Honda',
                'kategori' => 'Motor',
                'tahun' => 2023,
                'warna' => 'Putih',
                'harga_sewa_per_hari' => 140000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H4004DD',
                'nama_model' => 'Aerox 155',
                'merek' => 'Yamaha',
                'kategori' => 'Motor',
                'tahun' => 2022,
                'warna' => 'Kuning',
                'harga_sewa_per_hari' => 135000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H5005EE',
                'nama_model' => 'Vario 150',
                'merek' => 'Honda',
                'kategori' => 'Motor',
                'tahun' => 2021,
                'warna' => 'Hitam',
                'harga_sewa_per_hari' => 100000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nopol' => 'H6006FF',
                'nama_model' => 'W175',
                'merek' => 'Kawasaki',
                'kategori' => 'Motor',
                'tahun' => 2020,
                'warna' => 'Hijau',
                'harga_sewa_per_hari' => 200000,
                'status_ketersediaan' => 'Tersedia',
                'kondisi_teknis' => 'Layak Digunakan',
                'is_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
