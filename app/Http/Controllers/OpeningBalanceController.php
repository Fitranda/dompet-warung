<?php

namespace App\Http\Controllers;

use App\Models\OpeningBalance;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpeningBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $openingBalances = OpeningBalance::where('umkm_id', Auth::user()->umkm_id)
            ->with(['account'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('opening-balances.index', compact('openingBalances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        return view('opening-balances.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'saldo_awal' => 'required|numeric',
            'bulan' => 'required|date',
        ]);

        // Check if opening balance already exists for this account
        $existingBalance = OpeningBalance::where('umkm_id', Auth::user()->umkm_id)
            ->where('account_id', $request->account_id)
            ->first();

        if ($existingBalance) {
            return back()->withErrors(['account_id' => 'Saldo awal untuk akun ini sudah ada']);
        }

        OpeningBalance::create([
            'umkm_id' => Auth::user()->umkm_id,
            'account_id' => $request->account_id,
            'saldo_awal' => $request->saldo_awal,
            'bulan' => $request->bulan,
        ]);

        return redirect()->route('opening-balances.index')
            ->with('success', 'Saldo awal berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(OpeningBalance $openingBalance)
    {
        // Ensure opening balance belongs to user's UMKM
        if ($openingBalance->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        return view('opening-balances.show', compact('openingBalance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OpeningBalance $openingBalance)
    {
        // Ensure opening balance belongs to user's UMKM
        if ($openingBalance->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        return view('opening-balances.edit', compact('openingBalance', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OpeningBalance $openingBalance)
    {
        // Ensure opening balance belongs to user's UMKM
        if ($openingBalance->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'saldo_awal' => 'required|numeric',
            'bulan' => 'required|date',
        ]);

        // Check if opening balance already exists for this account (except current one)
        $existingBalance = OpeningBalance::where('umkm_id', Auth::user()->umkm_id)
            ->where('account_id', $request->account_id)
            ->where('id', '!=', $openingBalance->id)
            ->first();

        if ($existingBalance) {
            return back()->withErrors(['account_id' => 'Saldo awal untuk akun ini sudah ada']);
        }

        $openingBalance->update([
            'account_id' => $request->account_id,
            'saldo_awal' => $request->saldo_awal,
            'bulan' => $request->bulan,
        ]);

        return redirect()->route('opening-balances.index')
            ->with('success', 'Saldo awal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OpeningBalance $openingBalance)
    {
        // Ensure opening balance belongs to user's UMKM
        if ($openingBalance->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $openingBalance->delete();

        return redirect()->route('opening-balances.index')
            ->with('success', 'Saldo awal berhasil dihapus');
    }

    /**
     * Show the form for bulk creating opening balances.
     */
    public function bulkCreate()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        return view('opening-balances.bulk-create', compact('accounts'));
    }

    /**
     * Store multiple opening balances at once.
     */
    public function bulkStore(Request $request)
    {
        $request->validate([
            'bulan' => 'required|date',
            'opening_balances' => 'required|array|min:1',
            'opening_balances.*.account_id' => 'required|exists:accounts,id',
            'opening_balances.*.saldo_awal' => 'required|numeric',
        ]);

        $successCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($request->opening_balances as $index => $balanceData) {
            // Skip empty saldo_awal
            if (empty($balanceData['saldo_awal']) || $balanceData['saldo_awal'] == 0) {
                continue;
            }

            try {
                // Check if opening balance already exists for this account
                $existingBalance = OpeningBalance::where('umkm_id', Auth::user()->umkm_id)
                    ->where('account_id', $balanceData['account_id'])
                    ->first();

                if ($existingBalance) {
                    // Update existing balance
                    $existingBalance->update([
                        'saldo_awal' => $balanceData['saldo_awal'],
                        'bulan' => $request->bulan,
                    ]);
                    $successCount++;
                } else {
                    // Create new balance
                    OpeningBalance::create([
                        'umkm_id' => Auth::user()->umkm_id,
                        'account_id' => $balanceData['account_id'],
                        'saldo_awal' => $balanceData['saldo_awal'],
                        'bulan' => $request->bulan,
                    ]);
                    $successCount++;
                }
            } catch (\Exception $e) {
                $errorCount++;
                $account = Account::find($balanceData['account_id']);
                $errors[] = "Error pada akun {$account->nama_akun}: " . $e->getMessage();
            }
        }

        if ($successCount > 0) {
            $message = "Berhasil menyimpan {$successCount} saldo awal";
            if ($errorCount > 0) {
                $message .= " dengan {$errorCount} error";
            }

            if (!empty($errors)) {
                return redirect()->route('opening-balances.index')
                    ->with('success', $message)
                    ->with('errors', $errors);
            }

            return redirect()->route('opening-balances.index')
                ->with('success', $message);
        } else {
            return back()->withErrors(['opening_balances' => 'Tidak ada data yang valid untuk disimpan'])->withInput();
        }
    }
}
