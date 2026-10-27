<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t004_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nopol', 15)->unique();
            $table->string('nama_model', 100);
            $table->string('merek', 50);
            $table->string('kategori', 50);
            $table->year('tahun');
            $table->string('warna', 30);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_sewa_per_hari', 12, 2);
            $table->string('foto_kendaraan')->nullable(); // Disimpan sebagai path
            $table->string('kondisi_teknis', 50)->default('Layak Digunakan');
            $table->enum('status_ketersediaan', ['Tersedia', 'Dipesan', 'Disewa', 'Tidak Tersedia']);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t004_kendaraan');
    }
};
