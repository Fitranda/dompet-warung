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
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('kode_umkm', 10)->unique(); // Kode unik untuk setiap UMKM
            $table->string('nama_umkm');
            $table->string('nama_pemilik');
            $table->string('email')->unique();
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('jenis_usaha', 100)->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->string('npwp', 20)->nullable();
            $table->string('nik_pemilik', 20)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->json('pengaturan')->nullable(); // Untuk menyimpan pengaturan khusus UMKM
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
