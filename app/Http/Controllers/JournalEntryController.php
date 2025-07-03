<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\JournalDetail;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journalEntries = JournalEntry::where('umkm_id', Auth::user()->umkm_id)
            ->with(['details.account'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('journal-entries.index', compact('journalEntries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        return view('journal-entries.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'details' => 'required|array|min:2',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debit' => 'nullable|numeric|min:0',
            'details.*.kredit' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Calculate totals
            $totalDebit = collect($request->details)->sum('debit');
            $totalKredit = collect($request->details)->sum('kredit');

            // Validate balanced journal entry
            if ($totalDebit != $totalKredit) {
                throw new \Exception('Total debit harus sama dengan total kredit');
            }

            // Generate journal number
            $lastJournal = JournalEntry::where('umkm_id', Auth::user()->umkm_id)
                ->whereYear('tanggal', date('Y', strtotime($request->tanggal)))
                ->orderBy('no_jurnal', 'desc')
                ->first();

            $nextNumber = 1;
            if ($lastJournal) {
                $lastNumber = intval(substr($lastJournal->no_jurnal, -4));
                $nextNumber = $lastNumber + 1;
            }

            $noJurnal = 'JU-' . date('Y', strtotime($request->tanggal)) . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Create journal entry
            $journalEntry = JournalEntry::create([
                'umkm_id' => Auth::user()->umkm_id,
                'no_jurnal' => $noJurnal,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'total_debit' => $totalDebit,
                'total_kredit' => $totalKredit,
                'created_by' => Auth::id(),
            ]);

            // Create journal details
            foreach ($request->details as $detail) {
                if ($detail['debit'] > 0 || $detail['kredit'] > 0) {
                    JournalDetail::create([
                        'umkm_id' => Auth::user()->umkm_id,
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $detail['account_id'],
                        'debit' => $detail['debit'] ?? 0,
                        'kredit' => $detail['kredit'] ?? 0,
                    ]);
                }
            }
        });

        return redirect()->route('journal-entries.index')
            ->with('success', 'Jurnal berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(JournalEntry $journalEntry)
    {
        // Ensure journal entry belongs to user's UMKM
        if ($journalEntry->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $journalEntry->load(['details.account']);

        return view('journal-entries.show', compact('journalEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JournalEntry $journalEntry)
    {
        // Ensure journal entry belongs to user's UMKM
        if ($journalEntry->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        $journalEntry->load(['details.account']);

        return view('journal-entries.edit', compact('journalEntry', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JournalEntry $journalEntry)
    {
        // Ensure journal entry belongs to user's UMKM
        if ($journalEntry->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'details' => 'required|array|min:2',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debit' => 'nullable|numeric|min:0',
            'details.*.kredit' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $journalEntry) {
            // Calculate totals
            $totalDebit = collect($request->details)->sum('debit');
            $totalKredit = collect($request->details)->sum('kredit');

            // Validate balanced journal entry
            if ($totalDebit != $totalKredit) {
                throw new \Exception('Total debit harus sama dengan total kredit');
            }

            // Update journal entry
            $journalEntry->update([
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
                'total_debit' => $totalDebit,
                'total_kredit' => $totalKredit,
            ]);

            // Delete existing details
            $journalEntry->details()->delete();

            // Create new details
            foreach ($request->details as $detail) {
                if ($detail['debit'] > 0 || $detail['kredit'] > 0) {
                    JournalDetail::create([
                        'umkm_id' => Auth::user()->umkm_id,
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $detail['account_id'],
                        'debit' => $detail['debit'] ?? 0,
                        'kredit' => $detail['kredit'] ?? 0,
                    ]);
                }
            }
        });

        return redirect()->route('journal-entries.index')
            ->with('success', 'Jurnal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JournalEntry $journalEntry)
    {
        // Ensure journal entry belongs to user's UMKM
        if ($journalEntry->umkm_id !== Auth::user()->umkm_id) {
            abort(403);
        }

        $journalEntry->delete();

        return redirect()->route('journal-entries.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }
}
