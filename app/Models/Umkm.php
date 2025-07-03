<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    protected $fillable = [
        'kode_umkm',
        'nama_umkm',
        'nama_pemilik',
        'email',
        'telepon',
        'alamat',
        'jenis_usaha',
        'tanggal_berdiri',
        'npwp',
        'nik_pemilik',
        'status',
        'pengaturan'
    ];

    protected $casts = [
        'pengaturan' => 'array',
        'tanggal_berdiri' => 'date',
    ];

    /**
     * Generate kode UMKM unik
     */
    public static function generateKodeUmkm(): string
    {
        do {
            $kode = 'UMK' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('kode_umkm', $kode)->exists());

        return $kode;
    }

    /**
     * Relasi ke User (owner)
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class)->where('role', 'owner');
    }

    /**
     * Relasi ke semua Users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke Accounts
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Relasi ke Journal Entries
     */
    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }

    /**
     * Relasi ke Opening Balances
     */
    public function openingBalances(): HasMany
    {
        return $this->hasMany(OpeningBalance::class);
    }
}
