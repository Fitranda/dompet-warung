<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_number',
        'transaction_date',
        'reference',
        'description',
        'total_amount',
        'user_id'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationship dengan user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan transaction details
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Method untuk generate nomor transaksi otomatis
    public static function generateTransactionNumber()
    {
        $date = now();
        $prefix = 'TXN-' . $date->format('Ymd') . '-';

        $lastTransaction = self::where('transaction_number', 'like', $prefix . '%')
            ->orderBy('transaction_number', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction->transaction_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Method untuk validasi double entry
    public function isBalanced(): bool
    {
        $totalDebit = $this->details()->sum('debit_amount');
        $totalCredit = $this->details()->sum('credit_amount');

        return $totalDebit == $totalCredit;
    }
}
