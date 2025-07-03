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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique(); // Nomor transaksi
            $table->date('transaction_date'); // Tanggal transaksi
            $table->string('reference')->nullable(); // Referensi/bukti transaksi
            $table->text('description'); // Keterangan transaksi
            $table->decimal('total_amount', 15, 2); // Total amount
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang input
            $table->timestamps();

            $table->index(['transaction_date', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
