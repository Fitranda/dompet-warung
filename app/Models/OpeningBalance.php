<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpeningBalance extends Model
{
    protected $fillable = [
        'account_id',
        'fiscal_year',
        'debit_balance',
        'credit_balance'
    ];

    protected $casts = [
        'debit_balance' => 'decimal:2',
        'credit_balance' => 'decimal:2',
    ];

    // Relationship dengan account
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
