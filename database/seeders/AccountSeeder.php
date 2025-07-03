<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            // ASET (1-xxxx)
            [
                'code' => '1-0000',
                'name' => 'ASET',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => null,
                'description' => 'Kelompok Aset'
            ],
            [
                'code' => '1-1000',
                'name' => 'ASET LANCAR',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 1,
                'description' => 'Aset Lancar'
            ],
            [
                'code' => '1-1001',
                'name' => 'Kas',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 2,
                'description' => 'Kas di tangan'
            ],
            [
                'code' => '1-1002',
                'name' => 'Bank',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 2,
                'description' => 'Kas di bank'
            ],
            [
                'code' => '1-1003',
                'name' => 'Piutang Dagang',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 2,
                'description' => 'Piutang kepada pelanggan'
            ],
            [
                'code' => '1-1004',
                'name' => 'Persediaan Barang',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 2,
                'description' => 'Persediaan barang dagangan'
            ],
            [
                'code' => '1-2000',
                'name' => 'ASET TETAP',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 1,
                'description' => 'Aset Tetap'
            ],
            [
                'code' => '1-2001',
                'name' => 'Peralatan',
                'type' => 'asset',
                'normal_balance' => 'debit',
                'parent_id' => 7,
                'description' => 'Peralatan usaha'
            ],

            // KEWAJIBAN (2-xxxx)
            [
                'code' => '2-0000',
                'name' => 'KEWAJIBAN',
                'type' => 'liability',
                'normal_balance' => 'credit',
                'parent_id' => null,
                'description' => 'Kelompok Kewajiban'
            ],
            [
                'code' => '2-1000',
                'name' => 'KEWAJIBAN LANCAR',
                'type' => 'liability',
                'normal_balance' => 'credit',
                'parent_id' => 9,
                'description' => 'Kewajiban Lancar'
            ],
            [
                'code' => '2-1001',
                'name' => 'Utang Dagang',
                'type' => 'liability',
                'normal_balance' => 'credit',
                'parent_id' => 10,
                'description' => 'Utang kepada supplier'
            ],
            [
                'code' => '2-1002',
                'name' => 'Utang Bank',
                'type' => 'liability',
                'normal_balance' => 'credit',
                'parent_id' => 10,
                'description' => 'Utang kepada bank'
            ],

            // MODAL (3-xxxx)
            [
                'code' => '3-0000',
                'name' => 'MODAL',
                'type' => 'equity',
                'normal_balance' => 'credit',
                'parent_id' => null,
                'description' => 'Kelompok Modal'
            ],
            [
                'code' => '3-1001',
                'name' => 'Modal Pemilik',
                'type' => 'equity',
                'normal_balance' => 'credit',
                'parent_id' => 13,
                'description' => 'Modal yang disetor pemilik'
            ],
            [
                'code' => '3-2001',
                'name' => 'Laba Ditahan',
                'type' => 'equity',
                'normal_balance' => 'credit',
                'parent_id' => 13,
                'description' => 'Laba yang tidak dibagikan'
            ],

            // PENDAPATAN (4-xxxx)
            [
                'code' => '4-0000',
                'name' => 'PENDAPATAN',
                'type' => 'revenue',
                'normal_balance' => 'credit',
                'parent_id' => null,
                'description' => 'Kelompok Pendapatan'
            ],
            [
                'code' => '4-1001',
                'name' => 'Penjualan',
                'type' => 'revenue',
                'normal_balance' => 'credit',
                'parent_id' => 16,
                'description' => 'Pendapatan dari penjualan'
            ],

            // BEBAN (5-xxxx)
            [
                'code' => '5-0000',
                'name' => 'BEBAN',
                'type' => 'expense',
                'normal_balance' => 'debit',
                'parent_id' => null,
                'description' => 'Kelompok Beban'
            ],
            [
                'code' => '5-1001',
                'name' => 'Harga Pokok Penjualan',
                'type' => 'expense',
                'normal_balance' => 'debit',
                'parent_id' => 18,
                'description' => 'Harga pokok barang yang dijual'
            ],
            [
                'code' => '5-2001',
                'name' => 'Beban Gaji',
                'type' => 'expense',
                'normal_balance' => 'debit',
                'parent_id' => 18,
                'description' => 'Beban gaji karyawan'
            ],
            [
                'code' => '5-2002',
                'name' => 'Beban Listrik',
                'type' => 'expense',
                'normal_balance' => 'debit',
                'parent_id' => 18,
                'description' => 'Beban listrik'
            ],
            [
                'code' => '5-2003',
                'name' => 'Beban Sewa',
                'type' => 'expense',
                'normal_balance' => 'debit',
                'parent_id' => 18,
                'description' => 'Beban sewa tempat'
            ],
        ];

        foreach ($accounts as $account) {
            Account::create($account);
        }
    }
}
