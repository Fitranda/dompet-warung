<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Buat tabel baru sementara dengan struktur yang diinginkan
        Schema::create('opening_balances_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts');
            $table->date('bulan'); // Format: YYYY-MM-01 (tanggal 1 setiap bulan)
            $table->decimal('saldo_awal', 15, 2)->default(0);
            $table->timestamps();

            // Saldo awal harus unik per UMKM, akun, dan bulan
            $table->unique(['umkm_id', 'account_id', 'bulan']);
        });

        // Copy data dari tabel lama ke tabel baru, konversi tahun ke bulan
        DB::statement("
            INSERT INTO opening_balances_new (id, umkm_id, account_id, bulan, saldo_awal, created_at, updated_at)
            SELECT id, umkm_id, account_id, CONCAT(tahun, '-01-01'), saldo_awal, created_at, updated_at
            FROM opening_balances
        ");

        // Drop tabel lama
        Schema::dropIfExists('opening_balances');

        // Rename tabel baru ke nama asli
        Schema::rename('opening_balances_new', 'opening_balances');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Buat tabel baru sementara dengan struktur lama
        Schema::create('opening_balances_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('accounts');
            $table->year('tahun');
            $table->decimal('saldo_awal', 15, 2)->default(0);
            $table->timestamps();

            // Saldo awal harus unik per UMKM, akun, dan tahun
            $table->unique(['umkm_id', 'account_id', 'tahun']);
        });

        // Copy data dari tabel yang ada ke tabel lama, konversi bulan ke tahun
        DB::statement("
            INSERT INTO opening_balances_old (id, umkm_id, account_id, tahun, saldo_awal, created_at, updated_at)
            SELECT id, umkm_id, account_id, YEAR(bulan), saldo_awal, created_at, updated_at
            FROM opening_balances
        ");

        // Drop tabel yang ada
        Schema::dropIfExists('opening_balances');

        // Rename tabel lama ke nama asli
        Schema::rename('opening_balances_old', 'opening_balances');
    }
};
