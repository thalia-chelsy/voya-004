<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t004_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('t004_roles')->onDelete('restrict');
            
            $table->string('username', 50)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('email', 255)->unique(); // <-- Tambahkan ini
            $table->string('password');
            
            $table->string('foto_profil')->nullable(); // Disimpan sebagai path
            $table->enum('status_akun', ['Aktif', 'Blacklist'])->default('Aktif');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes(); // Untuk fitur nonaktif akun (tidak dihapus permanen)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t004_users');
    }
};
