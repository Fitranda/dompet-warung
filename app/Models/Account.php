<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    protected $fillable = [
        'umkm_id',
        'kode_akun',
        'nama_akun',
        'tipe_akun',
        'saldo_normal',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the UMKM that owns the account.
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    /**
     * Get the journal details for the account.
     */
    public function journalDetails(): HasMany
    {
        return $this->hasMany(JournalDetail::class);
    }

    /**
     * Get the opening balances for the account.
     */
    public function openingBalances(): HasMany
    {
        return $this->hasMany(OpeningBalance::class);
    }

    /**
     * Calculate account balance based on journal entries.
     */
    public function getBalance($startDate = null, $endDate = null)
    {
        $query = $this->journalDetails()
            ->join('journal_entries', 'journal_details.journal_entry_id', '=', 'journal_entries.id');

        if ($startDate) {
            $query->where('journal_entries.tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('journal_entries.tanggal', '<=', $endDate);
        }

        $totalDebit = $query->sum('journal_details.debit');
        $totalKredit = $query->sum('journal_details.kredit');

        // Get opening balance
        $openingBalance = $this->openingBalances()
            ->where('umkm_id', $this->umkm_id)
            ->first();

        $openingAmount = $openingBalance ? $openingBalance->saldo_awal : 0;

        // Calculate balance based on account type
        if ($this->saldo_normal === 'debit') {
            return $openingAmount + $totalDebit - $totalKredit;
        } else {
            return $openingAmount + $totalKredit - $totalDebit;
        }
    }

    /**
     * Get formatted account code and name.
     */
    public function getFormattedNameAttribute()
    {
        return $this->kode_akun . ' - ' . $this->nama_akun;
    }
}
