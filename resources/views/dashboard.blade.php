@section('title', 'Dashboard')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                {{-- <h                            @php
                                $recentJournalEntries = \App\Models\JournalEntry::where('umkm_id', Auth::user()->umkm_id)
                                    ->with(['user'])
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphps="text-xl sm:text-2xl md:text-3xl font-bold" style="color: #0F172A;">Dashboard Akuntansi</h1> --}}
                <p class="mt-1 flex items-center text-xs sm:text-sm md:text-base" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Selamat datang, <span class="font-semibold" style="color: #14B8A6;">{{ Auth::user()->name }}</span>!
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 md:space-y-8">

        <!-- Stats Overview Cards -->
        <div class="bg-white rounded-xl shadow-lg border p-4 md:p-6" style="border-color: #E2E8F0;">
            <h3 class="text-base md:text-lg font-semibold mb-4 flex items-center" style="color: #0F172A;">
                <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg flex items-center justify-center mr-2 md:mr-3" style="background: linear-gradient(135deg, #67E8F9 0%, #06B6D4 100%);">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                Ringkasan Statistik
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <!-- Card 1: Total Akun -->
                <div class="flex items-center p-3 md:p-4 rounded-lg border transition-all duration-200 hover:shadow-md" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium truncate" style="color: #64748B;">Total Akun</p>
                        <p class="text-xl md:text-2xl font-bold" style="color: #0F172A;">{{ \App\Models\Account::where('umkm_id', Auth::user()->umkm_id)->count() }}</p>
                        <p class="text-xs truncate" style="color: #14B8A6;">Chart of Accounts</p>
                    </div>
                </div>

                <!-- Card 2: Transaksi Bulan Ini -->
                <div class="flex items-center p-3 md:p-4 rounded-lg border transition-all duration-200 hover:shadow-md" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #67E8F9 0%, #06B6D4 100%);">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium truncate" style="color: #64748B;">Transaksi Bulan Ini</p>
                        <p class="text-xl md:text-2xl font-bold" style="color: #0F172A;">{{ \App\Models\JournalEntry::where('umkm_id', Auth::user()->umkm_id)->whereMonth('tanggal', now()->month)->count() }}</p>
                        <p class="text-xs truncate" style="color: #67E8F9;">{{ now()->format('F Y') }}</p>
                    </div>
                </div>

                <!-- Card 3: Aset Aktif -->
                <div class="flex items-center p-3 md:p-4 rounded-lg border transition-all duration-200 hover:shadow-md" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #0F172A 0%, #334155 100%);">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium truncate" style="color: #64748B;">Aset Aktif</p>
                        <p class="text-xl md:text-2xl font-bold" style="color: #0F172A;">{{ \App\Models\Account::where('umkm_id', Auth::user()->umkm_id)->where('tipe_akun', 'aset')->where('is_active', true)->count() }}</p>
                        <p class="text-xs truncate" style="color: #0F172A;">Assets</p>
                    </div>
                </div>

                <!-- Card 4: Saldo Awal -->
                <div class="flex items-center p-3 md:p-4 rounded-lg border transition-all duration-200 hover:shadow-md" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-lg flex items-center justify-center mr-3 md:mr-4 shadow-md flex-shrink-0" style="background: linear-gradient(135deg, #334155 0%, #475569 100%);">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium truncate" style="color: #64748B;">Saldo Awal Set</p>
                        <p class="text-xl md:text-2xl font-bold" style="color: #0F172A;">{{ \App\Models\OpeningBalance::where('umkm_id', Auth::user()->umkm_id)->count() }}</p>
                        <p class="text-xs truncate" style="color: #334155;">Opening Balance</p>
                    </div>
                </div>
            </div>
        </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 md:gap-6">
                <!-- Account Type Distribution Chart -->
                <div class="bg-white rounded-xl shadow-lg border hover:shadow-xl transition-shadow duration-300" style="border-color: #E2E8F0;">
                    <div class="p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-semibold mb-4 md:mb-6 flex items-center" style="color: #0F172A;">
                            <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg flex items-center justify-center mr-2 md:mr-3" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span class="text-sm md:text-base">Distribusi Jenis Akun</span>
                        </h3>
                        <div class="space-y-3 md:space-y-4">
                            @php
                                $accountTypes = \App\Models\Account::where('umkm_id', Auth::user()->umkm_id)
                                    ->selectRaw('tipe_akun, COUNT(*) as count')
                                    ->groupBy('tipe_akun')
                                    ->get();
                                $total = $accountTypes->sum('count');
                                $colors = [
                                    'aset' => ['bg-blue-500', 'bg-blue-50', 'text-blue-700', 'border-blue-200'],
                                    'kewajiban' => ['bg-red-500', 'bg-red-50', 'text-red-700', 'border-red-200'],
                                    'modal' => ['bg-green-500', 'bg-green-50', 'text-green-700', 'border-green-200'],
                                    'pendapatan' => ['bg-purple-500', 'bg-purple-50', 'text-purple-700', 'border-purple-200'],
                                    'beban' => ['bg-orange-500', 'bg-orange-50', 'text-orange-700', 'border-orange-200']
                                ];
                                $typeNames = [
                                    'aset' => 'Aset',
                                    'kewajiban' => 'Kewajiban',
                                    'modal' => 'Modal',
                                    'pendapatan' => 'Pendapatan',
                                    'beban' => 'Beban'
                                ];
                            @endphp
                            @foreach($accountTypes as $type)
                                @php
                                    $percentage = $total > 0 ? round(($type->count / $total) * 100, 1) : 0;
                                    $color = $colors[$type->tipe_akun] ?? ['bg-gray-500', 'bg-gray-50', 'text-gray-700', 'border-gray-200'];
                                @endphp
                                <div class="p-3 {{ $color[1] }} rounded-lg border {{ $color[3] }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2 md:space-x-3 min-w-0 flex-1">
                                            <div class="w-3 h-3 rounded-full {{ $color[0] }} flex-shrink-0"></div>
                                            <span class="text-sm font-medium text-gray-900 truncate">{{ $typeNames[$type->tipe_akun] ?? ucfirst($type->tipe_akun) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2 flex-shrink-0">
                                            <span class="text-base md:text-lg font-bold text-gray-900">{{ $type->count }}</span>
                                            <span class="text-xs {{ $color[2] }} font-semibold px-2 py-1 rounded-full bg-white border {{ $color[3] }}">{{ $percentage }}%</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 md:h-2.5">
                                        <div class="{{ $color[0] }} h-2 md:h-2.5 rounded-full transition-all duration-500 ease-out" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                            @if($total == 0)
                                <div class="text-center py-6 md:py-8">
                                    <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                        <svg class="w-6 h-6 md:w-8 md:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">Belum ada chart of accounts</p>
                                    <a href="{{ route('accounts.create') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        Buat akun pertama →
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-4 md:p-6">
                        <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-4 md:mb-6 flex items-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2 md:mr-3">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <span class="text-sm md:text-base">Aktivitas Terbaru</span>
                        </h3>
                        <div class="space-y-2 md:space-y-3">
                            @php
                                $recentJournalEntries = \App\Models\JournalEntry::with('user')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp
                            @forelse($recentJournalEntries as $entry)
                                <div class="flex items-center space-x-3 md:space-x-4 p-3 md:p-4 bg-gray-50 rounded-lg border border-gray-100 hover:bg-blue-50 hover:border-blue-200 transition-all duration-200">
                                    <div class="w-6 h-6 md:w-8 md:h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $entry->keterangan }}</p>
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 mt-1">
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($entry->tanggal)->format('d M Y') }}</p>
                                            <span class="hidden sm:inline text-gray-300">•</span>
                                            <p class="text-xs text-gray-500">{{ $entry->user->name ?? 'System' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right flex-shrink-0">
                                        <div class="text-xs md:text-sm font-bold text-green-600">
                                            Rp {{ number_format($entry->total_debit, 0, ',', '.') }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $entry->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6 md:py-8">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                        <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">Belum ada transaksi</p>
                                    <a href="{{ route('journal-entries.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Buat transaksi pertama
                                    </a>
                                </div>
                            @endforelse
                        </div>
                        @if($recentJournalEntries->count() > 0)
                        <div class="mt-3 md:mt-4 pt-3 md:pt-4 border-t border-gray-100">
                            <a href="{{ route('journal-entries.index') }}" class="block text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Lihat semua transaksi →
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 md:gap-6">
                <!-- Main Features -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-4 md:p-6">
                        <h3 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6 flex items-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2 md:mr-3">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            Fitur Utama
                        </h3>
                        <div class="space-y-3 md:space-y-4">
                            <a href="{{ route('accounts.index') }}" class="flex items-center p-3 md:p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 hover:shadow-md transition-all duration-200 group border border-blue-200">
                                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:from-blue-600 group-hover:to-blue-700 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-sm md:text-base">Kelola Kode Akun</h4>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Buat dan kelola chart of accounts</p>
                                </div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-blue-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('accounts.create') }}" class="flex items-center p-3 md:p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl hover:from-green-100 hover:to-green-200 hover:shadow-md transition-all duration-200 group border border-green-200">
                                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:from-green-600 group-hover:to-green-700 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors text-sm md:text-base">Tambah Akun Baru</h4>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Tambah kode akun untuk transaksi</p>
                                </div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-green-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('opening-balances.index') }}" class="flex items-center p-3 md:p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl hover:from-purple-100 hover:to-purple-200 hover:shadow-md transition-all duration-200 group border border-purple-200">
                                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:from-purple-600 group-hover:to-purple-700 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-purple-600 transition-colors text-sm md:text-base">Set Saldo Awal</h4>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Tentukan neraca saldo awal</p>
                                </div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-purple-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('journal-entries.quick-templates') }}" class="flex items-center p-3 md:p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl hover:from-orange-100 hover:to-orange-200 hover:shadow-md transition-all duration-200 group border border-orange-200">
                                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:from-orange-600 group-hover:to-orange-700 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors text-sm md:text-base">Jurnal Singkat</h4>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Buat jurnal dengan template siap pakai</p>
                                </div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-orange-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('journal-entries.index') }}" class="flex items-center p-3 md:p-4 bg-gradient-to-r from-teal-50 to-teal-100 rounded-xl hover:from-teal-100 hover:to-teal-200 hover:shadow-md transition-all duration-200 group border border-teal-200">
                                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mr-3 md:mr-4 group-hover:from-teal-600 group-hover:to-teal-700 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <div class="flex-grow min-w-0">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-teal-600 transition-colors text-sm md:text-base">Jurnal Umum</h4>
                                    <p class="text-xs md:text-sm text-gray-600 truncate">Lihat dan kelola semua jurnal umum</p>
                                </div>
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 group-hover:text-teal-600 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reports -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-4 md:p-6">
                        <h3 class="text-base sm:text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6 flex items-center">
                            <div class="w-6 h-6 md:w-8 md:h-8 bg-indigo-100 rounded-lg flex items-center justify-center mr-2 md:mr-3">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            Laporan Keuangan
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('reports.general-ledger') }}" class="block p-4 border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-indigo-600">Buku Besar</h4>
                                            <p class="text-sm text-gray-600">Lihat buku besar semua akun</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>



                            <a href="{{ route('reports.income-statement') }}" class="block p-4 border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-indigo-600">Laba Rugi</h4>
                                            <p class="text-sm text-gray-600">Laporan laba rugi</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>

                            <a href="{{ route('reports.balance-sheet') }}" class="block p-4 border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-indigo-300 hover:shadow-md transition-all duration-200 group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 group-hover:text-indigo-600">Neraca</h4>
                                            <p class="text-sm text-gray-600">Neraca/Balance sheet</p>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-admin-layout>
