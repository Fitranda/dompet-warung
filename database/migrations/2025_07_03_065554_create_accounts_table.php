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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
            $table->string('kode_akun', 10);
            $table->string('nama_akun');
            $table->enum('tipe_akun', ['aset', 'liabilitas', 'ekuitas', 'pendapatan', 'beban']);
            $table->enum('kategori', ['lancar', 'tidak_lancar', 'operasional', 'non_operasional'])->nullable();
            $table->string('parent_id')->nullable(); // Untuk hirarki akun
            $table->boolean('is_active')->default(true);
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Kode akun harus unik per UMKM
            $table->unique(['umkm_id', 'kode_akun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
