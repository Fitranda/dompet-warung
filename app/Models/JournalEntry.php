<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    protected $fillable = [
        'umkm_id',
        'no_jurnal',
        'tanggal',
        'referensi',
        'keterangan',
        'total_debet',
        'total_kredit',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_debet' => 'decimal:2',
        'total_kredit' => 'decimal:2',
    ];

    /**
     * Get the UMKM that owns the journal entry.
     */
    public function umkm(): BelongsTo
    {
        return $this->belongsTo(Umkm::class);
    }

    /**
     * Get the user who created the journal entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the journal details for the journal entry.
     */
    public function details(): HasMany
    {
        return $this->hasMany(JournalDetail::class);
    }
}
