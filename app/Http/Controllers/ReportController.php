<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalDetail;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display the trial balance report.
     */
    public function trialBalance()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->with(['journalDetails', 'openingBalances'])
            ->orderBy('kode_akun')
            ->get();

        return view('reports.trial-balance', compact('accounts'));
    }

    /**
     * Display the general ledger report.
     */
    public function generalLedger()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->with(['journalDetails.journalEntry'])
            ->orderBy('kode_akun')
            ->get();

        return view('reports.general-ledger', compact('accounts'));
    }

    /**
     * Display the worksheet report.
     */
    public function worksheet()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->with(['journalDetails', 'openingBalances'])
            ->orderBy('kode_akun')
            ->get();

        return view('reports.worksheet', compact('accounts'));
    }

    /**
     * Display the income statement report.
     */
    public function incomeStatement()
    {
        $revenueAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'pendapatan')
            ->with(['journalDetails'])
            ->orderBy('kode_akun')
            ->get();

        $expenseAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'beban')
            ->with(['journalDetails'])
            ->orderBy('kode_akun')
            ->get();

        return view('reports.income-statement', compact('revenueAccounts', 'expenseAccounts'));
    }

    /**
     * Display the balance sheet report.
     */
    public function balanceSheet()
    {
        $assetAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'aset')
            ->with(['journalDetails', 'openingBalances'])
            ->orderBy('kode_akun')
            ->get();

        $liabilityAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'kewajiban')
            ->with(['journalDetails', 'openingBalances'])
            ->orderBy('kode_akun')
            ->get();

        $equityAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'modal')
            ->with(['journalDetails', 'openingBalances'])
            ->orderBy('kode_akun')
            ->get();

        return view('reports.balance-sheet', compact('assetAccounts', 'liabilityAccounts', 'equityAccounts'));
    }
}
