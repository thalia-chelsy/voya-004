<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('t004_inspeksi_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('t004_kendaraan')->onDelete('cascade');
            $table->foreignId('inspector_id')->constrained('t004_users')->onDelete('cascade');
            $table->enum('tahapan', ['Pre-Rental', 'Post-Rental', 'Perawatan Rutin']);
            $table->boolean('kondisi_rem')->default(true);
            $table->boolean('kondisi_ban')->default(true);
            $table->boolean('kondisi_bodi')->default(true);
            $table->boolean('kondisi_mesin')->default(true);
            $table->string('status_teknis', 50)->default('Layak Jalan');
            $table->text('catatan_inspector')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t004_inspeksi_kendaraans');
    }
};
