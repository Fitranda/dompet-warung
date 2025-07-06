<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\Umkm;
use Illuminate\Console\Command;

class CreateDefaultAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'umkm:create-default-accounts {umkm_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default accounts for UMKM that don\'t have any accounts yet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $umkmId = $this->argument('umkm_id');

        if ($umkmId) {
            $umkms = Umkm::where('id', $umkmId)->get();
            if ($umkms->isEmpty()) {
                $this->error("UMKM with ID {$umkmId} not found.");
                return 1;
            }
        } else {
            // Get all UMKM that don't have any accounts
            $umkms = Umkm::whereDoesntHave('accounts')->get();
        }

        if ($umkms->isEmpty()) {
            $this->info('No UMKM found that need default accounts.');
            return 0;
        }

        foreach ($umkms as $umkm) {
            $this->info("Creating default accounts for UMKM: {$umkm->nama_umkm}");
            $this->createDefaultAccounts($umkm->id);
            $this->info("✓ Default accounts created for {$umkm->nama_umkm}");
        }

        $this->info('All default accounts have been created successfully!');
        return 0;
    }

    /**
     * Create default accounts for new UMKM
     */
    private function createDefaultAccounts(int $umkmId): void
    {
        $defaultAccounts = [
            // ASET
            [
                'kode_akun' => '1110',
                'nama_akun' => 'Kas',
                'tipe_akun' => 'aset',
                'kategori' => 'lancar',
            ],
            [
                'kode_akun' => '1120',
                'nama_akun' => 'Bank',
                'tipe_akun' => 'aset',
                'kategori' => 'lancar',
            ],
            [
                'kode_akun' => '1210',
                'nama_akun' => 'Piutang Usaha',
                'tipe_akun' => 'aset',
                'kategori' => 'lancar',
            ],
            [
                'kode_akun' => '1310',
                'nama_akun' => 'Persediaan Barang',
                'tipe_akun' => 'aset',
                'kategori' => 'lancar',
            ],
            [
                'kode_akun' => '1410',
                'nama_akun' => 'Peralatan Usaha',
                'tipe_akun' => 'aset',
                'kategori' => 'tidak_lancar',
            ],

            // LIABILITAS
            [
                'kode_akun' => '2110',
                'nama_akun' => 'Utang Usaha',
                'tipe_akun' => 'liabilitas',
                'kategori' => 'lancar',
            ],
            [
                'kode_akun' => '2120',
                'nama_akun' => 'Utang Bank',
                'tipe_akun' => 'liabilitas',
                'kategori' => 'tidak_lancar',
            ],

            // EKUITAS
            [
                'kode_akun' => '3110',
                'nama_akun' => 'Modal Pemilik',
                'tipe_akun' => 'ekuitas',
                'kategori' => null,
            ],
            [
                'kode_akun' => '3120',
                'nama_akun' => 'Prive Pemilik',
                'tipe_akun' => 'ekuitas',
                'kategori' => null,
            ],

            // PENDAPATAN
            [
                'kode_akun' => '4110',
                'nama_akun' => 'Penjualan',
                'tipe_akun' => 'pendapatan',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '4120',
                'nama_akun' => 'Pendapatan Jasa',
                'tipe_akun' => 'pendapatan',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '4910',
                'nama_akun' => 'Pendapatan Lain-lain',
                'tipe_akun' => 'pendapatan',
                'kategori' => 'non_operasional',
            ],

            // BEBAN
            [
                'kode_akun' => '5110',
                'nama_akun' => 'Harga Pokok Penjualan',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5210',
                'nama_akun' => 'Beban Gaji',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5220',
                'nama_akun' => 'Beban Listrik',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5230',
                'nama_akun' => 'Beban Sewa',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5240',
                'nama_akun' => 'Beban Transportasi',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5250',
                'nama_akun' => 'Beban Promosi',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5260',
                'nama_akun' => 'Beban Perlengkapan',
                'tipe_akun' => 'beban',
                'kategori' => 'operasional',
            ],
            [
                'kode_akun' => '5910',
                'nama_akun' => 'Beban Lain-lain',
                'tipe_akun' => 'beban',
                'kategori' => 'non_operasional',
            ],
        ];

        foreach ($defaultAccounts as $accountData) {
            Account::create([
                'umkm_id' => $umkmId,
                'kode_akun' => $accountData['kode_akun'],
                'nama_akun' => $accountData['nama_akun'],
                'tipe_akun' => $accountData['tipe_akun'],
                'kategori' => $accountData['kategori'],
                'is_active' => true,
                'deskripsi' => 'Akun standar UMKM',
            ]);
        }
    }
}
