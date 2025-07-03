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
            $table->string('code', 10)->unique(); // Kode akun (e.g., 1-1001)
            $table->string('name'); // Nama akun
            $table->enum('type', ['asset', 'liability', 'equity', 'revenue', 'expense']); // Jenis akun
            $table->enum('normal_balance', ['debit', 'credit']); // Saldo normal
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent account untuk sub-akun
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('accounts')->onDelete('set null');
            $table->index(['type', 'is_active']);
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
