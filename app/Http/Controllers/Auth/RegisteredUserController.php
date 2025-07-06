<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Umkm;
use App\Models\Account;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi tambahan untuk memastikan konsistensi data
        $additionalValidation = [];

        // Cek apakah email sudah terdaftar di tabel umkm juga
        if (Umkm::where('email', $request->email)->exists()) {
            $additionalValidation['email'] = 'Email sudah terdaftar untuk UMKM lain.';
        }

        // Cek apakah nama UMKM mirip dengan yang sudah ada (fuzzy check)
        $similarUmkm = Umkm::where('nama_umkm', 'LIKE', '%' . $request->nama_umkm . '%')->first();
        if ($similarUmkm) {
            $additionalValidation['nama_umkm'] = 'Nama UMKM mirip dengan yang sudah terdaftar: "' . $similarUmkm->nama_umkm . '". Silakan gunakan nama yang berbeda.';
        }

        if (!empty($additionalValidation)) {
            return back()->withInput()->withErrors($additionalValidation);
        }

        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama_umkm' => ['required', 'string', 'min:3', 'max:255', 'unique:umkm,nama_umkm'],
            'nama_pemilik' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'jenis_usaha' => ['required', 'string', 'in:Warung/Toko Kelontong,Rumah Makan/Kuliner,Fashion/Pakaian,Elektronik,Jasa,Lainnya'],
            'telepon' => ['nullable', 'string', 'min:10', 'max:15', 'regex:/^[0-9+\-\s()]+$/'],
            'alamat' => ['nullable', 'string', 'min:10', 'max:500'],
        ], [
            // Pesan validasi untuk data pemilik
            'name.required' => 'Nama lengkap pemilik wajib diisi.',
            'name.min' => 'Nama lengkap minimal 2 karakter.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'name.regex' => 'Nama lengkap hanya boleh berisi huruf dan spasi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau masuk ke akun yang sudah ada.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            // Pesan validasi untuk data UMKM
            'nama_umkm.required' => 'Nama UMKM/Usaha wajib diisi.',
            'nama_umkm.min' => 'Nama UMKM minimal 3 karakter.',
            'nama_umkm.max' => 'Nama UMKM maksimal 255 karakter.',
            'nama_umkm.unique' => 'Nama UMKM sudah terdaftar. Silakan gunakan nama yang berbeda.',

            'nama_pemilik.required' => 'Nama pemilik/penanggung jawab wajib diisi.',
            'nama_pemilik.min' => 'Nama pemilik minimal 2 karakter.',
            'nama_pemilik.max' => 'Nama pemilik maksimal 255 karakter.',
            'nama_pemilik.regex' => 'Nama pemilik hanya boleh berisi huruf dan spasi.',

            'jenis_usaha.required' => 'Jenis usaha wajib dipilih.',
            'jenis_usaha.in' => 'Jenis usaha yang dipilih tidak valid. Silakan pilih dari daftar yang tersedia.',

            'telepon.min' => 'Nomor telepon minimal 10 digit.',
            'telepon.max' => 'Nomor telepon maksimal 15 digit.',
            'telepon.regex' => 'Format nomor telepon tidak valid. Contoh: 08123456789 atau +6281234567890.',

            'alamat.min' => 'Alamat minimal 10 karakter untuk informasi yang lengkap.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Buat UMKM terlebih dahulu
                $umkm = Umkm::create([
                    'kode_umkm' => Umkm::generateKodeUmkm(),
                    'nama_umkm' => $request->nama_umkm,
                    'nama_pemilik' => $request->nama_pemilik,
                    'email' => $request->email,
                    'telepon' => $request->telepon,
                    'alamat' => $request->alamat,
                    'jenis_usaha' => $request->jenis_usaha,
                    'status' => 'aktif',
                ]);

                // Buat user sebagai owner UMKM
                $user = User::create([
                    'umkm_id' => $umkm->id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'owner',
                    'is_active' => true,
                ]);

                // Buat akun-akun standar UMKM
                $this->createDefaultAccounts($umkm->id);

                event(new Registered($user));

                Auth::login($user);
            });

            return redirect(route('dashboard', absolute: false))
                ->with('success', 'Selamat! UMKM Anda berhasil terdaftar. Chart of accounts standar telah dibuat otomatis.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['general' => 'Terjadi kesalahan saat mendaftarkan UMKM. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.'.$e->getMessage()]);
        }
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
