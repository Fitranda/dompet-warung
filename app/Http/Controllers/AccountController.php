<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Account::where('umkm_id', Auth::user()->umkm_id);

        // Filter pencarian umum
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('kode_akun', 'like', "%{$search}%")
                  ->orWhere('nama_akun', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Filter kode akun
        if ($request->filled('kode_akun')) {
            $query->where('kode_akun', 'like', '%' . $request->get('kode_akun') . '%');
        }

        // Filter nama akun
        if ($request->filled('nama_akun')) {
            $query->where('nama_akun', 'like', '%' . $request->get('nama_akun') . '%');
        }

        // Filter tipe akun
        if ($request->filled('tipe_akun')) {
            $query->where('tipe_akun', $request->get('tipe_akun'));
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->get('kategori'));
        }

        // Filter status aktif
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->get('is_active'));
        }

        $accounts = $query->orderBy('kode_akun')->paginate(15);

        // Hitung jumlah filter aktif
        $activeFilters = collect($request->all())
            ->except(['page'])
            ->filter(function($value) {
                return !empty($value);
            })
            ->count();

        return view('accounts.index', compact('accounts', 'activeFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_akun' => 'required|string|max:10',
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:aset,liabilitas,ekuitas,pendapatan,beban',
            'kategori' => 'nullable|in:lancar,tidak_lancar,operasional,non_operasional',
            'parent_id' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'deskripsi' => 'nullable|string',
        ]);

        // Check if account code already exists for this UMKM
        $existingAccount = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('kode_akun', $request->kode_akun)
            ->first();

        if ($existingAccount) {
            return back()->withErrors(['kode_akun' => 'Kode akun sudah digunakan']);
        }

        Account::create([
            'umkm_id' => Auth::user()->umkm_id,
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'tipe_akun' => $request->tipe_akun,
            'kategori' => $request->kategori,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active ?? true,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('accounts.index')
            ->with('success', 'Akun berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        // Ensure account belongs to user's UMKM
        if ($account->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        return view('accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        // Ensure account belongs to user's UMKM
        if ($account->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        // Ensure account belongs to user's UMKM
        if ($account->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $request->validate([
            'kode_akun' => 'required|string|max:10',
            'nama_akun' => 'required|string|max:255',
            'tipe_akun' => 'required|in:aset,liabilitas,ekuitas,pendapatan,beban',
            'kategori' => 'nullable|in:lancar,tidak_lancar,operasional,non_operasional',
            'parent_id' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'deskripsi' => 'nullable|string',
        ]);

        // Check if account code already exists for this UMKM (except current account)
        $existingAccount = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('kode_akun', $request->kode_akun)
            ->where('id', '!=', $account->id)
            ->first();

        if ($existingAccount) {
            return back()->withErrors(['kode_akun' => 'Kode akun sudah digunakan']);
        }

        $account->update([
            'kode_akun' => $request->kode_akun,
            'nama_akun' => $request->nama_akun,
            'tipe_akun' => $request->tipe_akun,
            'kategori' => $request->kategori,
            'parent_id' => $request->parent_id,
            'is_active' => $request->is_active ?? true,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('accounts.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        // Ensure account belongs to user's UMKM
        if ($account->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        // Check if account is being used in journal entries
        if ($account->journalDetails()->exists()) {
            return back()->withErrors(['delete' => 'Akun tidak dapat dihapus karena sudah digunakan dalam jurnal']);
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Akun berhasil dihapus');
    }

    /**
     * Export accounts to Excel
     */
    public function export(Request $request)
    {
        $query = Account::where('umkm_id', Auth::user()->umkm_id);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('kode_akun', 'like', "%{$search}%")
                  ->orWhere('nama_akun', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kode_akun')) {
            $query->where('kode_akun', 'like', '%' . $request->get('kode_akun') . '%');
        }

        if ($request->filled('nama_akun')) {
            $query->where('nama_akun', 'like', '%' . $request->get('nama_akun') . '%');
        }

        if ($request->filled('tipe_akun')) {
            $query->where('tipe_akun', $request->get('tipe_akun'));
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->get('kategori'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->get('is_active'));
        }

        $accounts = $query->orderBy('kode_akun')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="daftar-akun-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($accounts) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Kode Akun',
                'Nama Akun',
                'Tipe Akun',
                'Kategori',
                'Parent ID',
                'Status',
                'Deskripsi',
                'Dibuat Pada'
            ]);

            // Data
            foreach ($accounts as $account) {
                fputcsv($file, [
                    $account->kode_akun,
                    $account->nama_akun,
                    ucfirst($account->tipe_akun),
                    $account->kategori ? ucfirst(str_replace('_', ' ', $account->kategori)) : '',
                    $account->parent_id ?? '',
                    $account->is_active ? 'Aktif' : 'Tidak Aktif',
                    $account->deskripsi ?? '',
                    $account->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
