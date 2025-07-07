<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalDetail;
use App\Models\OpeningBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

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
    public function generalLedger(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $accountId = $request->get('account_id');
        $tipeAkun = $request->get('tipe_akun');

        // Get ledger data using the helper method
        $ledgerData = $this->getLedgerData($startDate, $endDate, $accountId, $tipeAkun);

        // Get all accounts for filter dropdown
        $allAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        return view('reports.general-ledger', compact(
            'ledgerData',
            'allAccounts',
            'startDate',
            'endDate',
            'accountId',
            'tipeAkun'
        ));
    }

    /**
     * Get ledger entries for a specific account within date range.
     */
    private function getAccountLedgerEntries($account, $startDate, $endDate)
    {
        return JournalDetail::where('account_id', $account->id)
            ->join('journal_entries', 'journal_details.journal_entry_id', '=', 'journal_entries.id')
            ->whereBetween('journal_entries.tanggal', [$startDate, $endDate])
            ->select(
                'journal_details.*',
                'journal_entries.tanggal',
                'journal_entries.no_jurnal',
                'journal_entries.keterangan as jurnal_keterangan'
            )
            ->orderBy('journal_entries.tanggal')
            ->orderBy('journal_entries.id')
            ->get();
    }

    /**
     * Get opening balance for an account before start date.
     */
    private function getOpeningBalance($account, $startDate)
    {
        // Get opening balance from opening_balances table
        $openingBalance = OpeningBalance::where('account_id', $account->id)
            ->where('umkm_id', Auth::user()->umkm_id)
            ->first();

        $opening = $openingBalance ? $openingBalance->saldo_awal : 0;

        // Add all transactions before start date
        $beforeStartDate = JournalDetail::where('account_id', $account->id)
            ->join('journal_entries', 'journal_details.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.tanggal', '<', $startDate)
            ->selectRaw('SUM(COALESCE(debet, 0)) as total_debet, SUM(COALESCE(kredit, 0)) as total_kredit')
            ->first();

        $totalDebet = $beforeStartDate->total_debet ?? 0;
        $totalKredit = $beforeStartDate->total_kredit ?? 0;

        // Calculate balance based on account normal balance
        if (in_array($account->tipe_akun, ['aset', 'beban'])) {
            return $opening + $totalDebet - $totalKredit;
        } else {
            return $opening + $totalKredit - $totalDebet;
        }
    }

    /**
     * Get closing balance for an account up to end date.
     */
    private function getClosingBalance($account, $endDate)
    {
        // Get opening balance
        $openingBalance = OpeningBalance::where('account_id', $account->id)
            ->where('umkm_id', Auth::user()->umkm_id)
            ->first();

        $opening = $openingBalance ? $openingBalance->saldo_awal : 0;

        // Add all transactions up to end date
        $upToEndDate = JournalDetail::where('account_id', $account->id)
            ->join('journal_entries', 'journal_details.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.tanggal', '<=', $endDate)
            ->selectRaw('SUM(COALESCE(debet, 0)) as total_debet, SUM(COALESCE(kredit, 0)) as total_kredit')
            ->first();

        $totalDebet = $upToEndDate->total_debet ?? 0;
        $totalKredit = $upToEndDate->total_kredit ?? 0;

        // Calculate balance based on account normal balance
        if (in_array($account->tipe_akun, ['aset', 'beban'])) {
            return $opening + $totalDebet - $totalKredit;
        } else {
            return $opening + $totalKredit - $totalDebet;
        }
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
    public function incomeStatement(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfYear()->format('Y-m-d'));
        $includeDetail = $request->get('include_detail', false);

        // Get revenue accounts with calculations
        $revenueAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'pendapatan')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        // Get expense accounts with calculations
        $expenseAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'beban')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        // Calculate balances for each account
        $revenueData = [];
        $totalRevenue = 0;
        foreach ($revenueAccounts as $account) {
            $balance = $this->getAccountBalance($account, $startDate, $endDate);
            if ($balance != 0 || $includeDetail) {
                $revenueData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalRevenue += $balance;
            }
        }

        $expenseData = [];
        $totalExpense = 0;
        foreach ($expenseAccounts as $account) {
            $balance = $this->getAccountBalance($account, $startDate, $endDate);
            if ($balance != 0 || $includeDetail) {
                $expenseData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalExpense += $balance;
            }
        }

        $netIncome = $totalRevenue - $totalExpense;

        return view('reports.income-statement', compact(
            'revenueData',
            'expenseData',
            'totalRevenue',
            'totalExpense',
            'netIncome',
            'startDate',
            'endDate',
            'includeDetail'
        ));
    }

    /**
     * Export income statement to PDF.
     */
    public function exportIncomeStatementPdf(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfYear()->format('Y-m-d'));
        $includeDetail = $request->get('include_detail', false);

        // Get income statement data
        $data = $this->getIncomeStatementData($startDate, $endDate, $includeDetail);

        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // Portrait for income statement
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
        ]);

        // Generate HTML content for PDF
        $html = $this->generateIncomeStatementPdfHtml($data, $startDate, $endDate, $includeDetail);

        $mpdf->WriteHTML($html);

        $filename = 'laporan_laba_rugi_' . $startDate . '_to_' . $endDate . '.pdf';

        return $mpdf->Output($filename, 'D');
    }

    /**
     * Export income statement to Excel XLSX.
     */
    public function exportIncomeStatementExcel(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfYear()->format('Y-m-d'));
        $includeDetail = $request->get('include_detail', false);

        // Get income statement data
        $data = $this->getIncomeStatementData($startDate, $endDate, $includeDetail);

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Generate Excel content
        $this->generateIncomeStatementExcelContent($sheet, $data, $startDate, $endDate, $includeDetail);

        $filename = 'laporan_laba_rugi_' . $startDate . '_to_' . $endDate . '.xlsx';

        // Create writer and download
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Get income statement data - helper method.
     */
    private function getIncomeStatementData($startDate, $endDate, $includeDetail = false)
    {
        // Get revenue accounts
        $revenueAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'pendapatan')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        // Get expense accounts
        $expenseAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'beban')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        $revenueData = [];
        $totalRevenue = 0;
        foreach ($revenueAccounts as $account) {
            $balance = $this->getAccountBalance($account, $startDate, $endDate);
            if ($balance != 0 || $includeDetail) {
                $revenueData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalRevenue += $balance;
            }
        }

        $expenseData = [];
        $totalExpense = 0;
        foreach ($expenseAccounts as $account) {
            $balance = $this->getAccountBalance($account, $startDate, $endDate);
            if ($balance != 0 || $includeDetail) {
                $expenseData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalExpense += $balance;
            }
        }

        return [
            'revenueData' => $revenueData,
            'expenseData' => $expenseData,
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'netIncome' => $totalRevenue - $totalExpense
        ];
    }

    /**
     * Get account balance for a period.
     */
    private function getAccountBalance($account, $startDate, $endDate)
    {
        $transactions = JournalDetail::where('account_id', $account->id)
            ->join('journal_entries', 'journal_details.journal_entry_id', '=', 'journal_entries.id')
            ->whereBetween('journal_entries.tanggal', [$startDate, $endDate])
            ->selectRaw('SUM(COALESCE(debet, 0)) as total_debet, SUM(COALESCE(kredit, 0)) as total_kredit')
            ->first();

        $totalDebet = $transactions->total_debet ?? 0;
        $totalKredit = $transactions->total_kredit ?? 0;

        // For income statement: Revenue = Credit - Debit, Expense = Debit - Credit
        if ($account->tipe_akun == 'pendapatan') {
            return $totalKredit - $totalDebet;
        } else {
            return $totalDebet - $totalKredit;
        }
    }

    /**
     * Display the balance sheet report.
     */
    public function balanceSheet(Request $request)
    {
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $includeDetail = $request->get('include_detail', false);

        // Get balance sheet data
        $data = $this->getBalanceSheetData($endDate, $includeDetail);

        return view('reports.balance-sheet', compact(
            'endDate',
            'includeDetail'
        ) + $data);
    }

    /**
     * Export balance sheet to PDF.
     */
    public function exportBalanceSheetPdf(Request $request)
    {
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $includeDetail = $request->get('include_detail', false);

        // Get balance sheet data
        $data = $this->getBalanceSheetData($endDate, $includeDetail);

        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P', // Portrait for balance sheet
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
        ]);

        // Generate HTML content for PDF
        $html = $this->generateBalanceSheetPdfHtml($data, $endDate, $includeDetail);

        $mpdf->WriteHTML($html);

        $filename = 'neraca_' . $endDate . '.pdf';

        return $mpdf->Output($filename, 'D');
    }

    /**
     * Export balance sheet to Excel XLSX.
     */
    public function exportBalanceSheetExcel(Request $request)
    {
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $includeDetail = $request->get('include_detail', false);

        // Get balance sheet data
        $data = $this->getBalanceSheetData($endDate, $includeDetail);

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Generate Excel content
        $this->generateBalanceSheetExcelContent($sheet, $data, $endDate, $includeDetail);

        $filename = 'neraca_' . $endDate . '.xlsx';

        // Create writer and download
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Export general ledger to PDF.
     */
    public function exportGeneralLedgerPdf(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $accountId = $request->get('account_id');
        $tipeAkun = $request->get('tipe_akun');

        // Get ledger data using the same logic as the main method
        $ledgerData = $this->getLedgerData($startDate, $endDate, $accountId, $tipeAkun);

        // Create mPDF instance
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'L', // Landscape for better table layout
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 16,
            'margin_bottom' => 16,
        ]);

        // Generate HTML content for PDF
        $html = $this->generatePdfHtml($ledgerData, $startDate, $endDate);

        $mpdf->WriteHTML($html);

        $filename = 'buku_besar_' . $startDate . '_to_' . $endDate . '.pdf';

        return $mpdf->Output($filename, 'D'); // 'D' for download
    }

    /**
     * Export general ledger to Excel XLSX.
     */
    public function exportGeneralLedgerExcel(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $accountId = $request->get('account_id');
        $tipeAkun = $request->get('tipe_akun');

        // Get ledger data using the same logic as the main method
        $ledgerData = $this->getLedgerData($startDate, $endDate, $accountId, $tipeAkun);

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Generate Excel content
        $this->generateGeneralLedgerExcelContent($sheet, $ledgerData, $startDate, $endDate);

        $filename = 'buku_besar_' . $startDate . '_to_' . $endDate . '.xlsx';

        // Create writer and download
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    /**
     * Get ledger data - extracted to reusable method.
     */
    private function getLedgerData($startDate, $endDate, $accountId = null, $tipeAkun = null)
    {
        // Base query for accounts
        $accountsQuery = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('is_active', true);

        // Filter by account type if specified
        if ($tipeAkun) {
            $accountsQuery->where('tipe_akun', $tipeAkun);
        }

        // Filter by specific account if specified
        if ($accountId) {
            $accountsQuery->where('id', $accountId);
        }

        $accounts = $accountsQuery->orderBy('kode_akun')->get();

        // Get ledger data for each account
        $ledgerData = [];
        foreach ($accounts as $account) {
            $entries = $this->getAccountLedgerEntries($account, $startDate, $endDate);
            if (!empty($entries) || $accountId) {
                $ledgerData[] = [
                    'account' => $account,
                    'entries' => $entries,
                    'opening_balance' => $this->getOpeningBalance($account, $startDate),
                    'closing_balance' => $this->getClosingBalance($account, $endDate)
                ];
            }
        }

        return $ledgerData;
    }

    /**
     * Generate HTML content for PDF.
     */
    private function generatePdfHtml($ledgerData, $startDate, $endDate)
    {
        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 10px; }
            .header { text-align: center; margin-bottom: 20px; }
            .company-name { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
            .report-title { font-size: 14px; font-weight: bold; margin-bottom: 5px; }
            .period { font-size: 12px; margin-bottom: 10px; }
            .account-header {
                background-color: #f8f9fa;
                padding: 8px;
                margin-top: 15px;
                border: 1px solid #dee2e6;
                font-weight: bold;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            th, td {
                border: 1px solid #dee2e6;
                padding: 6px;
                text-align: left;
            }
            th {
                background-color: #e9ecef;
                font-weight: bold;
                text-align: center;
            }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .opening-balance { background-color: #e3f2fd; }
            .closing-balance { background-color: #e8f5e8; font-weight: bold; }
            .page-break { page-break-before: always; }
        </style>

        <div class="header">
            <div class="company-name">DOMPET WARUNG</div>
            <div class="report-title">BUKU BESAR (GENERAL LEDGER)</div>
            <div class="period">Periode: ' . date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)) . '</div>
            <div>Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>
        </div>';

        foreach ($ledgerData as $index => $data) {
            if ($index > 0) {
                $html .= '<div class="page-break"></div>';
            }

            $html .= '
            <div class="account-header">
                AKUN: ' . $data['account']->kode_akun . ' - ' . $data['account']->nama_akun . '<br>
                Tipe: ' . ucfirst($data['account']->tipe_akun) . ' | Saldo Normal: ' . ucfirst($data['account']->saldo_normal) . '
            </div>

            <table>
                <thead>
                    <tr>
                        <th width="12%">Tanggal</th>
                        <th width="15%">No. Jurnal</th>
                        <th width="30%">Keterangan</th>
                        <th width="13%">Debet</th>
                        <th width="13%">Kredit</th>
                        <th width="17%">Saldo</th>
                    </tr>
                </thead>
                <tbody>';

            // Opening balance
            $html .= '
                    <tr class="opening-balance">
                        <td class="text-center">' . date('d/m/Y', strtotime($startDate)) . '</td>
                        <td class="text-center">-</td>
                        <td><strong>Saldo Awal</strong></td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                        <td class="text-right"><strong>' . number_format(abs($data['opening_balance']), 0, ',', '.') . ($data['opening_balance'] < 0 ? ' (-)' : '') . '</strong></td>
                    </tr>';

            $runningBalance = $data['opening_balance'];

            // Transactions
            foreach ($data['entries'] as $entry) {
                // Calculate running balance
                if (in_array($data['account']->tipe_akun, ['aset', 'beban'])) {
                    $runningBalance += ($entry->debet ?? 0) - ($entry->kredit ?? 0);
                } else {
                    $runningBalance += ($entry->kredit ?? 0) - ($entry->debet ?? 0);
                }

                $html .= '
                    <tr>
                        <td class="text-center">' . date('d/m/Y', strtotime($entry->tanggal)) . '</td>
                        <td class="text-center">' . $entry->no_jurnal . '</td>
                        <td>' . ($entry->keterangan ?: $entry->jurnal_keterangan) . '</td>
                        <td class="text-right">' . ($entry->debet ? number_format($entry->debet, 0, ',', '.') : '-') . '</td>
                        <td class="text-right">' . ($entry->kredit ? number_format($entry->kredit, 0, ',', '.') : '-') . '</td>
                        <td class="text-right">' . number_format(abs($runningBalance), 0, ',', '.') . ($runningBalance < 0 ? ' (-)' : '') . '</td>
                    </tr>';
            }

            // Closing balance
            $html .= '
                    <tr class="closing-balance">
                        <td class="text-center">' . date('d/m/Y', strtotime($endDate)) . '</td>
                        <td class="text-center">-</td>
                        <td><strong>Saldo Akhir</strong></td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                        <td class="text-right"><strong>' . number_format(abs($data['closing_balance']), 0, ',', '.') . ($data['closing_balance'] < 0 ? ' (-)' : '') . '</strong></td>
                    </tr>';

            $html .= '
                </tbody>
            </table>';
        }

        if (empty($ledgerData)) {
            $html .= '<div style="text-align: center; margin-top: 50px; font-size: 14px;">Tidak ada data untuk ditampilkan</div>';
        }

        return $html;
    }

    /**
     * Generate HTML content for Income Statement PDF.
     */
    private function generateIncomeStatementPdfHtml($data, $startDate, $endDate, $includeDetail)
    {
        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 11px; }
            .header { text-align: center; margin-bottom: 25px; }
            .company-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
            .report-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
            .period { font-size: 12px; margin-bottom: 10px; }
            .section-title {
                font-size: 14px;
                font-weight: bold;
                margin: 20px 0 10px 0;
                padding: 8px;
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            th, td {
                border: 1px solid #dee2e6;
                padding: 8px;
                text-align: left;
            }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .account-line { border-bottom: 1px solid #eee; }
            .total-line {
                font-weight: bold;
                background-color: #f8f9fa;
                border-top: 2px solid #333;
            }
            .net-income {
                font-weight: bold;
                background-color: #e8f5e8;
                border: 2px solid #333;
                font-size: 12px;
            }
            .detail-table { margin-left: 20px; font-size: 9px; }
        </style>

        <div class="header">
            <div class="company-name">DOMPET WARUNG</div>
            <div class="report-title">LAPORAN LABA RUGI</div>
            <div class="period">Periode: ' . date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)) . '</div>
            <div>Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>
        </div>

        <table>
            <tbody>';

        // PENDAPATAN Section
        $html .= '
                <tr class="section-title">
                    <td><strong>PENDAPATAN</strong></td>
                    <td class="text-right"><strong>Jumlah (Rp)</strong></td>
                </tr>';

        foreach ($data['revenueData'] as $item) {
            $html .= '
                <tr class="account-line">
                    <td style="padding-left: 20px;">' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun . '</td>
                    <td class="text-right">' . number_format($item['balance'], 0, ',', '.') . '</td>
                </tr>';

            // Detail transactions if requested
            if ($includeDetail && !empty($item['details'])) {
                $html .= '<tr><td colspan="2">
                    <table class="detail-table">
                        <tr><th>Tanggal</th><th>No. Jurnal</th><th>Keterangan</th><th>Jumlah</th></tr>';

                foreach ($item['details'] as $detail) {
                    $amount = $detail->kredit - $detail->debet;
                    $html .= '<tr>
                        <td>' . date('d/m/Y', strtotime($detail->tanggal)) . '</td>
                        <td>' . $detail->no_jurnal . '</td>
                        <td>' . ($detail->keterangan ?: $detail->jurnal_keterangan) . '</td>
                        <td class="text-right">' . number_format($amount, 0, ',', '.') . '</td>
                    </tr>';
                }

                $html .= '</table></td></tr>';
            }
        }

        $html .= '
                <tr class="total-line">
                    <td><strong>TOTAL PENDAPATAN</strong></td>
                    <td class="text-right"><strong>' . number_format($data['totalRevenue'], 0, ',', '.') . '</strong></td>
                </tr>';

        // BEBAN Section
        $html .= '
                <tr class="section-title">
                    <td><strong>BEBAN</strong></td>
                    <td class="text-right"><strong>Jumlah (Rp)</strong></td>
                </tr>';

        foreach ($data['expenseData'] as $item) {
            $html .= '
                <tr class="account-line">
                    <td style="padding-left: 20px;">' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun . '</td>
                    <td class="text-right">' . number_format($item['balance'], 0, ',', '.') . '</td>
                </tr>';

            // Detail transactions if requested
            if ($includeDetail && !empty($item['details'])) {
                $html .= '<tr><td colspan="2">
                    <table class="detail-table">
                        <tr><th>Tanggal</th><th>No. Jurnal</th><th>Keterangan</th><th>Jumlah</th></tr>';

                foreach ($item['details'] as $detail) {
                    $amount = $detail->debet - $detail->kredit;
                    $html .= '<tr>
                        <td>' . date('d/m/Y', strtotime($detail->tanggal)) . '</td>
                        <td>' . $detail->no_jurnal . '</td>
                        <td>' . ($detail->keterangan ?: $detail->jurnal_keterangan) . '</td>
                        <td class="text-right">' . number_format($amount, 0, ',', '.') . '</td>
                    </tr>';
                }

                $html .= '</table></td></tr>';
            }
        }

        $html .= '
                <tr class="total-line">
                    <td><strong>TOTAL BEBAN</strong></td>
                    <td class="text-right"><strong>' . number_format($data['totalExpense'], 0, ',', '.') . '</strong></td>
                </tr>';

        // NET INCOME
        $netIncomeClass = $data['netIncome'] >= 0 ? 'net-income' : 'net-income';
        $netIncomeLabel = $data['netIncome'] >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH';

        $html .= '
                <tr class="' . $netIncomeClass . '">
                    <td><strong>' . $netIncomeLabel . '</strong></td>
                    <td class="text-right"><strong>' . number_format(abs($data['netIncome']), 0, ',', '.') . ($data['netIncome'] < 0 ? ' (-)' : '') . '</strong></td>
                </tr>';

        $html .= '
            </tbody>
        </table>';

        if (empty($data['revenueData']) && empty($data['expenseData'])) {
            $html .= '<div style="text-align: center; margin-top: 50px; font-size: 14px;">Tidak ada data untuk periode yang dipilih</div>';
        }

        return $html;
    }

    /**
     * Generate Excel content for Income Statement.
     */
    private function generateIncomeStatementExcelContent($sheet, $data, $startDate, $endDate, $includeDetail)
    {
        $sheet->setTitle('Laporan Laba Rugi');

        // Header
        $sheet->setCellValue('A1', 'DOMPET WARUNG');
        $sheet->setCellValue('A2', 'LAPORAN LABA RUGI');
        $sheet->setCellValue('A3', 'Periode: ' . date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)));
        $sheet->setCellValue('A4', 'Tanggal Cetak: ' . date('d/m/Y H:i:s'));

        // Style header
        $sheet->getStyle('A1:B1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:B2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:B3')->getFont()->setSize(12);
        $sheet->getStyle('A1:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge cells for header
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('A4:B4');

        $currentRow = 6;

        // PENDAPATAN Section
        $sheet->setCellValue('A' . $currentRow, 'PENDAPATAN');
        $sheet->setCellValue('B' . $currentRow, 'Jumlah (Rp)');
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');
        $currentRow++;

        foreach ($data['revenueData'] as $item) {
            $sheet->setCellValue('A' . $currentRow, '  ' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun);
            $sheet->setCellValue('B' . $currentRow, number_format($item['balance'], 0, ',', '.'));
            $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $currentRow++;

            // Detail transactions if requested
            if ($includeDetail && !empty($item['details'])) {
                foreach ($item['details'] as $detail) {
                    $amount = $detail->kredit - $detail->debet;
                    $sheet->setCellValue('A' . $currentRow, '    ' . date('d/m/Y', strtotime($detail->tanggal)) . ' - ' . $detail->no_jurnal . ' - ' . ($detail->keterangan ?: $detail->jurnal_keterangan));
                    $sheet->setCellValue('B' . $currentRow, number_format($amount, 0, ',', '.'));
                    $sheet->getStyle('A' . $currentRow)->getFont()->setSize(9);
                    $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $currentRow++;
                }
            }
        }

        // Total Revenue
        $sheet->setCellValue('A' . $currentRow, 'TOTAL PENDAPATAN');
        $sheet->setCellValue('B' . $currentRow, number_format($data['totalRevenue'], 0, ',', '.'));
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $currentRow += 2;

        // BEBAN Section
        $sheet->setCellValue('A' . $currentRow, 'BEBAN');
        $sheet->setCellValue('B' . $currentRow, 'Jumlah (Rp)');
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');
        $currentRow++;

        foreach ($data['expenseData'] as $item) {
            $sheet->setCellValue('A' . $currentRow, '  ' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun);
            $sheet->setCellValue('B' . $currentRow, number_format($item['balance'], 0, ',', '.'));
            $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $currentRow++;

            // Detail transactions if requested
            if ($includeDetail && !empty($item['details'])) {
                foreach ($item['details'] as $detail) {
                    $amount = $detail->debet - $detail->kredit;
                    $sheet->setCellValue('A' . $currentRow, '    ' . date('d/m/Y', strtotime($detail->tanggal)) . ' - ' . $detail->no_jurnal . ' - ' . ($detail->keterangan ?: $detail->jurnal_keterangan));
                    $sheet->setCellValue('B' . $currentRow, number_format($amount, 0, ',', '.'));
                    $sheet->getStyle('A' . $currentRow)->getFont()->setSize(9);
                    $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                    $currentRow++;
                }
            }
        }

        // Total Expense
        $sheet->setCellValue('A' . $currentRow, 'TOTAL BEBAN');
        $sheet->setCellValue('B' . $currentRow, number_format($data['totalExpense'], 0, ',', '.'));
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $currentRow += 2;

        // Net Income
        $netIncomeLabel = $data['netIncome'] >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH';
        $sheet->setCellValue('A' . $currentRow, $netIncomeLabel);
        $sheet->setCellValue('B' . $currentRow, number_format(abs($data['netIncome']), 0, ',', '.') . ($data['netIncome'] < 0 ? ' (-)' : ''));
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true)->setSize(12);
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB($data['netIncome'] >= 0 ? 'E8F5E8' : 'FFEBEE');
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(20);

        // Apply borders to data area
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A6:B' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }

    /**
     * Generate Excel content for General Ledger.
     */
    private function generateGeneralLedgerExcelContent($sheet, $ledgerData, $startDate, $endDate)
    {
        $sheet->setTitle('Buku Besar');

        // Header
        $sheet->setCellValue('A1', 'DOMPET WARUNG');
        $sheet->setCellValue('A2', 'BUKU BESAR (GENERAL LEDGER)');
        $sheet->setCellValue('A3', 'Periode: ' . date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)));
        $sheet->setCellValue('A4', 'Tanggal Cetak: ' . date('d/m/Y H:i:s'));

        // Style header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:E2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:E3')->getFont()->setSize(12);
        $sheet->getStyle('A1:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge cells for header
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('A4:E4');

        $currentRow = 6;

        foreach ($ledgerData as $accountData) {
            // Account header
            $sheet->setCellValue('A' . $currentRow, $accountData['account']->kode_akun . ' - ' . $accountData['account']->nama_akun);
            $sheet->mergeCells('A' . $currentRow . ':E' . $currentRow);
            $sheet->getStyle('A' . $currentRow . ':E' . $currentRow)->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle('A' . $currentRow . ':E' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('E3F2FD');
            $currentRow++;

            // Column headers
            $sheet->setCellValue('A' . $currentRow, 'Tanggal');
            $sheet->setCellValue('B' . $currentRow, 'No. Jurnal');
            $sheet->setCellValue('C' . $currentRow, 'Keterangan');
            $sheet->setCellValue('D' . $currentRow, 'Debet');
            $sheet->setCellValue('E' . $currentRow, 'Kredit');
            $sheet->setCellValue('F' . $currentRow, 'Saldo');
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F5F5F5');
            $currentRow++;

            // Opening balance
            if ($accountData['openingBalance'] != 0) {
                $sheet->setCellValue('A' . $currentRow, '');
                $sheet->setCellValue('B' . $currentRow, '');
                $sheet->setCellValue('C' . $currentRow, 'Saldo Awal');
                $sheet->setCellValue('D' . $currentRow, '');
                $sheet->setCellValue('E' . $currentRow, '');
                $sheet->setCellValue('F' . $currentRow, number_format($accountData['openingBalance'], 0, ',', '.'));
                $sheet->getStyle('F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $currentRow++;
            }

            // Transactions
            foreach ($accountData['entries'] as $entry) {
                $sheet->setCellValue('A' . $currentRow, date('d/m/Y', strtotime($entry->tanggal)));
                $sheet->setCellValue('B' . $currentRow, $entry->no_jurnal);
                $sheet->setCellValue('C' . $currentRow, $entry->keterangan ?: $entry->jurnal_keterangan);
                $sheet->setCellValue('D' . $currentRow, $entry->debet > 0 ? number_format($entry->debet, 0, ',', '.') : '');
                $sheet->setCellValue('E' . $currentRow, $entry->kredit > 0 ? number_format($entry->kredit, 0, ',', '.') : '');
                $sheet->setCellValue('F' . $currentRow, number_format($entry->running_balance, 0, ',', '.'));

                $sheet->getStyle('D' . $currentRow . ':F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $currentRow++;
            }

            // Closing balance
            $sheet->setCellValue('A' . $currentRow, '');
            $sheet->setCellValue('B' . $currentRow, '');
            $sheet->setCellValue('C' . $currentRow, 'Saldo Akhir');
            $sheet->setCellValue('D' . $currentRow, number_format($accountData['closing_balance'], 0, ',', '.'));
            $sheet->setCellValue('E' . $currentRow, number_format($accountData['totalKredit'], 0, ',', '.'));
            $sheet->setCellValue('F' . $currentRow, number_format($accountData['endingBalance'], 0, ',', '.'));

            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFont()->setBold(true);
            $sheet->getStyle('D' . $currentRow . ':F' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFF3E0');

            $currentRow += 3; // Space between accounts
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(35);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

        // Apply borders to data area
        if ($currentRow > 6) {
            $sheet->getStyle('A6:F' . ($currentRow - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        }
    }

    /**
     * Get balance sheet data - helper method.
     */
    private function getBalanceSheetData($endDate, $includeDetail = false)
    {
        // Calculate start date for period balance calculation (beginning of year)
        $startDate = date('Y-01-01', strtotime($endDate));

        // Get asset accounts
        $assetAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'aset')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        // Process asset accounts
        $assetData = [];
        $totalAssets = 0;
        foreach ($assetAccounts as $account) {
            $balance = $this->getBalanceSheetAccountBalance($account, $endDate);
            if ($balance != 0 || $includeDetail) {
                $assetData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalAssets += $balance;
            }
        }

        // Get liability accounts
        $liabilityAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'liabilitas')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        // Process liability accounts
        $liabilityData = [];
        $totalLiabilities = 0;
        foreach ($liabilityAccounts as $account) {
            $balance = $this->getBalanceSheetAccountBalance($account, $endDate);
            if ($balance != 0 || $includeDetail) {
                $liabilityData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalLiabilities += $balance;
            }
        }

        // Get equity accounts
        $equityAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'ekuitas')
            ->where('is_active', true)
            ->orderBy('kode_akun')
            ->get();

        // Process equity accounts
        $equityData = [];
        $totalEquity = 0;
        foreach ($equityAccounts as $account) {
            $balance = $this->getBalanceSheetAccountBalance($account, $endDate);
            if ($balance != 0 || $includeDetail) {
                $equityData[] = [
                    'account' => $account,
                    'balance' => $balance,
                    'details' => $includeDetail ? $this->getAccountLedgerEntries($account, $startDate, $endDate) : []
                ];
                $totalEquity += $balance;
            }
        }

        // Calculate retained earnings (net income YTD)
        $retainedEarnings = $this->getRetainedEarnings($endDate);
        $totalEquity += $retainedEarnings;

        return [
            'assetData' => $assetData,
            'liabilityData' => $liabilityData,
            'equityData' => $equityData,
            'totalAssets' => $totalAssets,
            'totalLiabilities' => $totalLiabilities,
            'totalEquity' => $totalEquity,
            'retainedEarnings' => $retainedEarnings,
            'totalLiabilitiesEquity' => $totalLiabilities + $totalEquity,
            'isBalanced' => abs($totalAssets - ($totalLiabilities + $totalEquity)) < 0.01
        ];
    }

    /**
     * Get account balance for balance sheet (cumulative up to end date).
     */
    private function getBalanceSheetAccountBalance($account, $endDate)
    {
        // Get opening balance
        $openingBalance = OpeningBalance::where('account_id', $account->id)
            ->where('umkm_id', Auth::user()->umkm_id)
            ->first();

        $opening = $openingBalance ? $openingBalance->saldo_awal : 0;

        // Get all transactions up to end date
        $transactions = JournalDetail::where('account_id', $account->id)
            ->join('journal_entries', 'journal_details.journal_entry_id', '=', 'journal_entries.id')
            ->where('journal_entries.tanggal', '<=', $endDate)
            ->selectRaw('SUM(COALESCE(debet, 0)) as total_debet, SUM(COALESCE(kredit, 0)) as total_kredit')
            ->first();

        $totalDebet = $transactions->total_debet ?? 0;
        $totalKredit = $transactions->total_kredit ?? 0;

        // Calculate balance based on account normal balance
        if (in_array($account->tipe_akun, ['aset'])) {
            return $opening + $totalDebet - $totalKredit;
        } else {
            return $opening + $totalKredit - $totalDebet;
        }
    }

    /**
     * Get retained earnings (accumulated net income) up to end date.
     */
    private function getRetainedEarnings($endDate)
    {
        $startDate = '2000-01-01'; // From beginning of time

        // Get total revenue
        $revenueAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'pendapatan')
            ->where('is_active', true)
            ->get();

        $totalRevenue = 0;
        foreach ($revenueAccounts as $account) {
            $balance = $this->getAccountBalance($account, $startDate, $endDate);
            $totalRevenue += $balance;
        }

        // Get total expenses
        $expenseAccounts = Account::where('umkm_id', Auth::user()->umkm_id)
            ->where('tipe_akun', 'beban')
            ->where('is_active', true)
            ->get();

        $totalExpenses = 0;
        foreach ($expenseAccounts as $account) {
            $balance = $this->getAccountBalance($account, $startDate, $endDate);
            $totalExpenses += $balance;
        }

        return $totalRevenue - $totalExpenses;
    }

    /**
     * Generate HTML content for Balance Sheet PDF.
     */
    private function generateBalanceSheetPdfHtml($data, $endDate, $includeDetail)
    {
        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 11px; }
            .header { text-align: center; margin-bottom: 25px; }
            .company-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
            .report-title { font-size: 16px; font-weight: bold; margin-bottom: 5px; }
            .period { font-size: 12px; margin-bottom: 10px; }
            .section-title {
                font-size: 14px;
                font-weight: bold;
                margin: 20px 0 10px 0;
                padding: 8px;
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }
            th, td {
                border: 1px solid #dee2e6;
                padding: 8px;
                text-align: left;
            }
            .text-right { text-align: right; }
            .text-center { text-align: center; }
            .account-line { border-bottom: 1px solid #eee; }
            .total-line {
                font-weight: bold;
                background-color: #f8f9fa;
                border-top: 2px solid #333;
            }
            .grand-total {
                font-weight: bold;
                background-color: #e8f5e8;
                border: 2px solid #333;
                font-size: 12px;
            }
            .detail-table { margin-left: 20px; font-size: 9px; }
            .balance-check {
                background-color: ' . ($data['isBalanced'] ? '#e8f5e8' : '#ffebee') . ';
                color: ' . ($data['isBalanced'] ? '#2e7d32' : '#c62828') . ';
                padding: 10px;
                margin: 10px 0;
                border: 1px solid ' . ($data['isBalanced'] ? '#4caf50' : '#f44336') . ';
            }
        </style>

        <div class="header">
            <div class="company-name">DOMPET WARUNG</div>
            <div class="report-title">NERACA (BALANCE SHEET)</div>
            <div class="period">Per Tanggal: ' . date('d/m/Y', strtotime($endDate)) . '</div>
            <div>Tanggal Cetak: ' . date('d/m/Y H:i:s') . '</div>
        </div>

        <table><tbody>';

        // ASSETS Section
        $html .= '<tr class="section-title">
                    <td><strong>ASET</strong></td>
                    <td class="text-right"><strong>Jumlah (Rp)</strong></td>
                </tr>';

        foreach ($data['assetData'] as $item) {
            $html .= '<tr class="account-line">
                    <td style="padding-left: 20px;">' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun . '</td>
                    <td class="text-right">' . number_format(abs($item['balance']), 0, ',', '.') . '</td>
                </tr>';
        }

        $html .= '<tr class="total-line">
                    <td><strong>TOTAL ASET</strong></td>
                    <td class="text-right"><strong>' . number_format(abs($data['totalAssets']), 0, ',', '.') . '</strong></td>
                </tr>';

        // LIABILITIES Section
        $html .= '<tr class="section-title">
                    <td><strong>LIABILITAS</strong></td>
                    <td class="text-right"><strong>Jumlah (Rp)</strong></td>
                </tr>';

        foreach ($data['liabilityData'] as $item) {
            $html .= '<tr class="account-line">
                    <td style="padding-left: 20px;">' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun . '</td>
                    <td class="text-right">' . number_format(abs($item['balance']), 0, ',', '.') . '</td>
                </tr>';
        }

        $html .= '<tr class="total-line">
                    <td><strong>TOTAL LIABILITAS</strong></td>
                    <td class="text-right"><strong>' . number_format(abs($data['totalLiabilities']), 0, ',', '.') . '</strong></td>
                </tr>';

        // EQUITY Section
        $html .= '<tr class="section-title">
                    <td><strong>EKUITAS</strong></td>
                    <td class="text-right"><strong>Jumlah (Rp)</strong></td>
                </tr>';

        foreach ($data['equityData'] as $item) {
            $html .= '<tr class="account-line">
                    <td style="padding-left: 20px;">' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun . '</td>
                    <td class="text-right">' . number_format(abs($item['balance']), 0, ',', '.') . '</td>
                </tr>';
        }

        // Retained Earnings
        if ($data['retainedEarnings'] != 0) {
            $html .= '<tr class="account-line">
                    <td style="padding-left: 20px;">Saldo Laba Ditahan</td>
                    <td class="text-right">' . number_format(abs($data['retainedEarnings']), 0, ',', '.') . '</td>
                </tr>';
        }

        $html .= '<tr class="total-line">
                    <td><strong>TOTAL EKUITAS</strong></td>
                    <td class="text-right"><strong>' . number_format(abs($data['totalEquity']), 0, ',', '.') . '</strong></td>
                </tr>';

        // TOTAL LIABILITIES + EQUITY
        $html .= '<tr class="grand-total">
                    <td><strong>TOTAL LIABILITAS + EKUITAS</strong></td>
                    <td class="text-right"><strong>' . number_format(abs($data['totalLiabilitiesEquity']), 0, ',', '.') . '</strong></td>
                </tr>';

        $html .= '</tbody></table>';

        // Balance check
        $html .= '<div class="balance-check">
            <strong>Pengecekan Neraca:</strong><br>
            Total Aset: ' . number_format(abs($data['totalAssets']), 0, ',', '.') . '<br>
            Total Liabilitas + Ekuitas: ' . number_format(abs($data['totalLiabilitiesEquity']), 0, ',', '.') . '<br>
            Status: <strong>' . ($data['isBalanced'] ? 'SEIMBANG ✓' : 'TIDAK SEIMBANG ✗') . '</strong>
        </div>';

        return $html;
    }

    /**
     * Generate Excel content for Balance Sheet.
     */
    private function generateBalanceSheetExcelContent($sheet, $data, $endDate, $includeDetail)
    {
        $sheet->setTitle('Neraca');

        // Header
        $sheet->setCellValue('A1', 'DOMPET WARUNG');
        $sheet->setCellValue('A2', 'NERACA (BALANCE SHEET)');
        $sheet->setCellValue('A3', 'Per Tanggal: ' . date('d/m/Y', strtotime($endDate)));
        $sheet->setCellValue('A4', 'Tanggal Cetak: ' . date('d/m/Y H:i:s'));

        // Style header
        $sheet->getStyle('A1:B1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:B2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3:B3')->getFont()->setSize(12);
        $sheet->getStyle('A1:A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Merge cells for header
        $sheet->mergeCells('A1:B1');
        $sheet->mergeCells('A2:B2');
        $sheet->mergeCells('A3:B3');
        $sheet->mergeCells('A4:B4');

        $currentRow = 6;

        // ASSETS Section
        $sheet->setCellValue('A' . $currentRow, 'ASET');
        $sheet->setCellValue('B' . $currentRow, 'Jumlah (Rp)');
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8F9FA');
        $currentRow++;

        foreach ($data['assetData'] as $item) {
            $sheet->setCellValue('A' . $currentRow, '  ' . $item['account']->kode_akun . ' - ' . $item['account']->nama_akun);
            $sheet->setCellValue('B' . $currentRow, number_format(abs($item['balance']), 0, ',', '.'));
            $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $currentRow++;
        }

        // Total Assets
        $sheet->setCellValue('A' . $currentRow, 'TOTAL ASET');
        $sheet->setCellValue('B' . $currentRow, number_format(abs($data['totalAssets']), 0, ',', '.'));
        $sheet->getStyle('A' . $currentRow . ':B' . $currentRow)->getFont()->setBold(true);
        $sheet->getStyle('B' . $currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $currentRow += 2;

        // Continue with other sections...

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(20);

        // Apply borders to data area
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A6:B' . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
