<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t004_transaksi_sewa', function (Blueprint $table) {
            $table->id();
            // Relasi ke user dan kendaraan
            $table->foreignId('penyewa_id')->constrained('t004_users')->onDelete('restrict');
            $table->foreignId('kendaraan_id')->constrained('t004_kendaraan')->onDelete('restrict');
            
            $table->date('tgl_mulai');
            $table->date('tgl_rencana_kembali');
            $table->date('tgl_kembali_aktual')->nullable();
            
            $table->decimal('harga_sewa_per_hari', 12, 2);
            $table->integer('jumlah_hari_sewa');
            $table->decimal('total_biaya', 15, 2);
            
            $table->enum('status', [
                'Menunggu Konfirmasi', 'Disetujui', 'Ditolak', 
                'Menunggu Pengambilan', 'Sedang Disewa', 
                'Menunggu Pemeriksaan', 'Selesai', 'Dibatalkan'
            ])->default('Menunggu Konfirmasi');
            
            $table->text('catatan_operasional')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t004_transaksi_sewa');
    }
};