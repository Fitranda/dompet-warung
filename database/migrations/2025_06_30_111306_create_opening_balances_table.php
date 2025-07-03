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
        Schema::create('opening_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->year('fiscal_year'); // Tahun fiskal
            $table->decimal('debit_balance', 15, 2)->default(0); // Saldo awal debit
            $table->decimal('credit_balance', 15, 2)->default(0); // Saldo awal kredit
            $table->timestamps();

            $table->unique(['account_id', 'fiscal_year']);
            $table->index(['fiscal_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_balances');
    }
};
