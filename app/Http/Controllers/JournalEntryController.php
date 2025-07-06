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
    public function index(Request $request)
    {
        $query = JournalEntry::where('umkm_id', Auth::user()->umkm_id)
            ->with(['details.account']);

        // Filter by journal number
        if ($request->filled('no_jurnal')) {
            $query->where('no_jurnal', 'LIKE', '%' . $request->no_jurnal . '%');
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        // Filter by description
        if ($request->filled('keterangan')) {
            $query->where('keterangan', 'LIKE', '%' . $request->keterangan . '%');
        }

        // Filter by debit amount range
        if ($request->filled('debit_min') || $request->filled('debit_max')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->selectRaw('journal_entry_id, SUM(debit) as total_debit')
                  ->groupBy('journal_entry_id')
                  ->havingRaw('1=1'); // base condition

                if ($request->filled('debit_min')) {
                    $q->havingRaw('SUM(debit) >= ?', [$request->debit_min]);
                }

                if ($request->filled('debit_max')) {
                    $q->havingRaw('SUM(debit) <= ?', [$request->debit_max]);
                }
            });
        }

        $journalEntries = $query->orderBy('tanggal', 'desc')
            ->paginate(10)
            ->withQueryString(); // Preserve query parameters in pagination

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
     * Show quick journal templates for easy selection.
     */
    public function quickTemplates()
    {
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        // Get common account types for templates
        $kasAccount = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'aset')
            ->where('nama_akun', 'like', '%Kas%')
            ->first();;
        $bankAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'bank') !== false)
            ->first();

        $penjualanAccount = $accounts->where('tipe_akun', 'pendapatan')
            ->filter(fn($item) => stripos($item->nama_akun, 'penjualan') !== false)
            ->first();

        $modalAccount = $accounts->where('tipe_akun', 'ekuitas')
            ->filter(fn($item) => stripos($item->nama_akun, 'modal') !== false)
            ->first();

        $bebanAccount = $accounts->where('tipe_akun', 'beban')->first();

        $piutangAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'piutang') !== false)
            ->first();

        $utangAccount = $accounts->where('tipe_akun', 'liabilitas')
            ->filter(fn($item) => stripos($item->nama_akun, 'utang') !== false)
            ->first();

        $persediaanAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'persediaan') !== false)
            ->first();

        $templates = [
            [
                'id' => 'penjualan_tunai',
                'title' => 'Penjualan Tunai',
                'description' => 'Mencatat penjualan barang/jasa secara tunai',
                'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1',
                'color' => 'from-green-500 to-green-600',
                'accounts' => [
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $penjualanAccount ? $penjualanAccount->id : null, 'account_name' => $penjualanAccount ? ($penjualanAccount->kode_akun . ' - ' . $penjualanAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'pembelian_tunai',
                'title' => 'Pembelian Tunai',
                'description' => 'Mencatat pembelian barang/persediaan secara tunai',
                'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                'color' => 'from-red-500 to-red-600',
                'accounts' => [
                    ['account_id' => $persediaanAccount ? $persediaanAccount->id : null, 'account_name' => $persediaanAccount ? ($persediaanAccount->kode_akun . ' - ' . $persediaanAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'setoran_modal',
                'title' => 'Setoran Modal',
                'description' => 'Mencatat penambahan modal dari pemilik',
                'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
                'color' => 'from-blue-500 to-blue-600',
                'accounts' => [
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $modalAccount ? $modalAccount->id : null, 'account_name' => $modalAccount ? ($modalAccount->kode_akun . ' - ' . $modalAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'bayar_beban',
                'title' => 'Pembayaran Beban',
                'description' => 'Mencatat pembayaran berbagai beban operasional',
                'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
                'color' => 'from-orange-500 to-orange-600',
                'accounts' => [
                    ['account_id' => $bebanAccount ? $bebanAccount->id : null, 'account_name' => $bebanAccount ? ($bebanAccount->kode_akun . ' - ' . $bebanAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'penjualan_kredit',
                'title' => 'Penjualan Kredit',
                'description' => 'Mencatat penjualan secara kredit (piutang)',
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'color' => 'from-purple-500 to-purple-600',
                'accounts' => [
                    ['account_id' => $piutangAccount ? $piutangAccount->id : null, 'account_name' => $piutangAccount ? ($piutangAccount->kode_akun . ' - ' . $piutangAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $penjualanAccount ? $penjualanAccount->id : null, 'account_name' => $penjualanAccount ? ($penjualanAccount->kode_akun . ' - ' . $penjualanAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'terima_piutang',
                'title' => 'Penerimaan Piutang',
                'description' => 'Mencatat pembayaran piutang dari pelanggan',
                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'color' => 'from-teal-500 to-teal-600',
                'accounts' => [
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $piutangAccount ? $piutangAccount->id : null, 'account_name' => $piutangAccount ? ($piutangAccount->kode_akun . ' - ' . $piutangAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'transfer_bank',
                'title' => 'Transfer ke Bank',
                'description' => 'Mencatat transfer kas ke rekening bank',
                'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
                'color' => 'from-indigo-500 to-indigo-600',
                'accounts' => [
                    ['account_id' => $bankAccount ? $bankAccount->id : null, 'account_name' => $bankAccount ? ($bankAccount->kode_akun . ' - ' . $bankAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ],
            [
                'id' => 'bayar_utang',
                'title' => 'Pembayaran Utang',
                'description' => 'Mencatat pembayaran utang kepada supplier',
                'icon' => 'M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z',
                'color' => 'from-gray-500 to-gray-600',
                'accounts' => [
                    ['account_id' => $utangAccount ? $utangAccount->id : null, 'account_name' => $utangAccount ? ($utangAccount->kode_akun . ' - ' . $utangAccount->nama_akun) : '', 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'account_name' => $kasAccount ? ($kasAccount->kode_akun . ' - ' . $kasAccount->nama_akun) : '', 'type' => 'kredit']
                ]
            ]
        ];

        return view('journal-entries.quick-templates', compact('templates', 'accounts'));
    }

    /**
     * Create journal entry from template.
     */
    public function createFromTemplate(Request $request)
    {
        $templateId = $request->input('template');
        $accounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->orderBy('kode_akun')
            ->get();

        $templateData = $this->getTemplateData($templateId, $accounts);

        return view('journal-entries.create', compact('accounts', 'templateData'));
    }

    /**
     * Get template data by ID.
     */
    private function getTemplateData($templateId, $accounts)
    {
        $kasAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'kas') !== false)
            ->first();
        $bankAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'bank') !== false)
            ->first();

        $penjualanAccount = $accounts->where('tipe_akun', 'pendapatan')
            ->filter(fn($item) => stripos($item->nama_akun, 'penjualan') !== false)
            ->first();

        $modalAccount = $accounts->where('tipe_akun', 'ekuitas')
            ->filter(fn($item) => stripos($item->nama_akun, 'modal') !== false)
            ->first();

        $bebanAccount = $accounts->where('tipe_akun', 'beban')->first();

        $piutangAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'piutang') !== false)
            ->first();

        $utangAccount = $accounts->where('tipe_akun', 'liabilitas')
            ->filter(fn($item) => stripos($item->nama_akun, 'utang') !== false)
            ->first();

        $persediaanAccount = $accounts->where('tipe_akun', 'aset')
            ->filter(fn($item) => stripos($item->nama_akun, 'persediaan') !== false)
            ->first();

        $templates = [
            'penjualan_tunai' => [
                'title' => 'Penjualan Tunai',
                'description' => 'Mencatat penjualan barang/jasa secara tunai',
                'accounts' => [
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $penjualanAccount ? $penjualanAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'pembelian_tunai' => [
                'title' => 'Pembelian Tunai',
                'description' => 'Mencatat pembelian barang/persediaan secara tunai',
                'accounts' => [
                    ['account_id' => $persediaanAccount ? $persediaanAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'setoran_modal' => [
                'title' => 'Setoran Modal',
                'description' => 'Mencatat penambahan modal dari pemilik',
                'accounts' => [
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $modalAccount ? $modalAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'bayar_beban' => [
                'title' => 'Pembayaran Beban',
                'description' => 'Mencatat pembayaran berbagai beban operasional',
                'accounts' => [
                    ['account_id' => $bebanAccount ? $bebanAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'penjualan_kredit' => [
                'title' => 'Penjualan Kredit',
                'description' => 'Mencatat penjualan secara kredit (piutang)',
                'accounts' => [
                    ['account_id' => $piutangAccount ? $piutangAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $penjualanAccount ? $penjualanAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'terima_piutang' => [
                'title' => 'Penerimaan Piutang',
                'description' => 'Mencatat pembayaran piutang dari pelanggan',
                'accounts' => [
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $piutangAccount ? $piutangAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'transfer_bank' => [
                'title' => 'Transfer ke Bank',
                'description' => 'Mencatat transfer kas ke rekening bank',
                'accounts' => [
                    ['account_id' => $bankAccount ? $bankAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'kredit']
                ]
            ],
            'bayar_utang' => [
                'title' => 'Pembayaran Utang',
                'description' => 'Mencatat pembayaran utang kepada supplier',
                'accounts' => [
                    ['account_id' => $utangAccount ? $utangAccount->id : null, 'type' => 'debet'],
                    ['account_id' => $kasAccount ? $kasAccount->id : null, 'type' => 'kredit']
                ]
            ]
        ];

        return $templates[$templateId] ?? null;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'referensi' => 'nullable|string|max:255',
            'keterangan' => 'required|string|max:255',
            'details' => 'required|array|min:2',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.debet' => 'nullable|numeric|min:0',
            'details.*.kredit' => 'nullable|numeric|min:0',
            'details.*.keterangan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            // Calculate totals
            $totalDebet = collect($request->details)->sum('debet');
            $totalKredit = collect($request->details)->sum('kredit');

            // Validate balanced journal entry
            if ($totalDebet != $totalKredit) {
                throw new \Exception('Total debet harus sama dengan total kredit');
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
                'referensi' => $request->referensi,
                'keterangan' => $request->keterangan,
                'total_debet' => $totalDebet,
                'total_kredit' => $totalKredit,
                'status' => 'posted',
                'created_by' => Auth::id(),
            ]);

            // Create journal details
            foreach ($request->details as $detail) {
                if (($detail['debet'] ?? 0) > 0 || ($detail['kredit'] ?? 0) > 0) {
                    JournalDetail::create([
                        'journal_entry_id' => $journalEntry->id,
                        'account_id' => $detail['account_id'],
                        'debet' => $detail['debet'] ?? 0,
                        'kredit' => $detail['kredit'] ?? 0,
                        'keterangan' => $detail['keterangan'] ?? null,
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
