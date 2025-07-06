<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JournalDetail extends Model
{
    protected $fillable = [
        'journal_entry_id',
        'account_id',
        'debet',
        'kredit',
        'keterangan',
    ];

    protected $casts = [
        'debet' => 'decimal:2',
        'kredit' => 'decimal:2',
    ];

    /**
     * Get the journal entry that owns the journal detail.
     */
    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    /**
     * Get the account that owns the journal detail.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
