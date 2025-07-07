<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\OpeningBalanceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Accounting Routes
    Route::resource('accounts', AccountController::class);
    Route::get('accounts-export', [AccountController::class, 'export'])->name('accounts.export');
    Route::resource('journal-entries', JournalEntryController::class);

    // Journal Entry Quick Templates
    Route::get('/journal-entries-quick-templates', [JournalEntryController::class, 'quickTemplates'])->name('journal-entries.quick-templates');
    Route::get('/journal-entries-create-from-template', [JournalEntryController::class, 'createFromTemplate'])->name('journal-entries.create-from-template');

    // Route::resource('transactions', TransactionController::class); // Disabled - using journal_entries instead
    Route::resource('opening-balances', OpeningBalanceController::class);

    // Opening Balance Bulk Operations
    Route::get('/opening-balances-bulk-create', [OpeningBalanceController::class, 'bulkCreate'])->name('opening-balances.bulk-create');
    Route::post('/opening-balances-bulk-store', [OpeningBalanceController::class, 'bulkStore'])->name('opening-balances.bulk-store');

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/trial-balance', [ReportController::class, 'trialBalance'])->name('trial-balance');
        Route::get('/general-ledger', [ReportController::class, 'generalLedger'])->name('general-ledger');
        Route::get('/general-ledger/export-pdf', [ReportController::class, 'exportGeneralLedgerPdf'])->name('general-ledger.export-pdf');
        Route::get('/general-ledger/export-excel', [ReportController::class, 'exportGeneralLedgerExcel'])->name('general-ledger.export-excel');
        Route::get('/worksheet', [ReportController::class, 'worksheet'])->name('worksheet');
        Route::get('/income-statement', [ReportController::class, 'incomeStatement'])->name('income-statement');
        Route::get('/income-statement/export-pdf', [ReportController::class, 'exportIncomeStatementPdf'])->name('income-statement.export.pdf');
        Route::get('/income-statement/export-excel', [ReportController::class, 'exportIncomeStatementExcel'])->name('income-statement.export.excel');
        Route::get('/balance-sheet', [ReportController::class, 'balanceSheet'])->name('balance-sheet');
        Route::get('/balance-sheet/export-pdf', [ReportController::class, 'exportBalanceSheetPdf'])->name('balance-sheet.export.pdf');
        Route::get('/balance-sheet/export-excel', [ReportController::class, 'exportBalanceSheetExcel'])->name('balance-sheet.export.excel');
    });
});

require __DIR__.'/auth.php';
