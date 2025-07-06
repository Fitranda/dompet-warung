<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpeningBalance extends Model
{
    protected $fillable = [
        'umkm_id',
        'account_id',
        'saldo_awal',
        'bulan',
    ];

    protected $casts = [
        'saldo_awal' => 'decimal:2',
        'bulan' => 'date',
    ];

    /**
     * Get the UMKM that owns the opening balance.
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    /**
     * Get the account that owns the opening balance.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
