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
    public function index()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->paginate(10);

        return view('accounts.index', compact('accounts'));
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
            'tipe_akun' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
            'saldo_normal' => 'required|in:debit,kredit',
            'is_active' => 'boolean',
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
            'saldo_normal' => $request->saldo_normal,
            'is_active' => $request->is_active ?? true,
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
            'tipe_akun' => 'required|in:aset,kewajiban,modal,pendapatan,beban',
            'saldo_normal' => 'required|in:debit,kredit',
            'is_active' => 'boolean',
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
            'saldo_normal' => $request->saldo_normal,
            'is_active' => $request->is_active ?? true,
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
}
