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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
            $table->string('no_jurnal', 20);
            $table->date('tanggal');
            $table->string('referensi')->nullable();
            $table->text('keterangan');
            $table->decimal('total_debet', 15, 2);
            $table->decimal('total_kredit', 15, 2);
            $table->enum('status', ['draft', 'posted', 'cancelled'])->default('draft');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            // Nomor jurnal harus unik per UMKM
            $table->unique(['umkm_id', 'no_jurnal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
