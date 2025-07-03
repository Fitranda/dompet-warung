<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'normal_balance',
        'parent_id',
        'is_active',
        'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship dengan parent account
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    // Relationship dengan sub accounts
    public function children(): HasMany
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    // Relationship dengan transaction details
    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Relationship dengan opening balances
    public function openingBalances(): HasMany
    {
        return $this->hasMany(OpeningBalance::class);
    }

    // Method untuk menghitung saldo
    public function getBalance($startDate = null, $endDate = null)
    {
        $query = $this->transactionDetails()
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id');

        if ($startDate) {
            $query->where('transactions.transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('transactions.transaction_date', '<=', $endDate);
        }

        $totalDebit = $query->sum('transaction_details.debit_amount');
        $totalCredit = $query->sum('transaction_details.credit_amount');

        return $this->normal_balance === 'debit'
            ? $totalDebit - $totalCredit
            : $totalCredit - $totalDebit;
    }
}
