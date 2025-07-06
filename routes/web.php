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
    Route::resource('journal-entries', JournalEntryController::class);

    // Journal Entry Quick Templates
    Route::get('/journal-entries-quick-templates', [JournalEntryController::class, 'quickTemplates'])->name('journal-entries.quick-templates');
    Route::get('/journal-entries-create-from-template', [JournalEntryController::class, 'createFromTemplate'])->name('journal-entries.create-from-template');

    // Route::resource('transactions', TransactionController::class); // Disabled - using journal_entries instead
    Route::resource('opening-balances', OpeningBalanceController::class);

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/trial-balance', [ReportController::class, 'trialBalance'])->name('trial-balance');
        Route::get('/general-ledger', [ReportController::class, 'generalLedger'])->name('general-ledger');
        Route::get('/worksheet', [ReportController::class, 'worksheet'])->name('worksheet');
        Route::get('/income-statement', [ReportController::class, 'incomeStatement'])->name('income-statement');
        Route::get('/balance-sheet', [ReportController::class, 'balanceSheet'])->name('balance-sheet');
    });
});

require __DIR__.'/auth.php';
