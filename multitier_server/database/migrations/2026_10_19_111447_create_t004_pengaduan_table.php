<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('t004_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID Penyewa
            $table->unsignedBigInteger('kendaraan_id'); // Kendaraan yang dikeluhkan
            $table->text('isi_pengaduan');
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t004_pengaduan');
    }
};
