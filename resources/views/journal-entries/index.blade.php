@section('title', 'Jurnal Umum')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Jurnal Umum</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="truncate">Kelola semua transaksi jurnal umum</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-green-50 border border-green-200 rounded-lg p-3 sm:p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <p class="text-xs sm:text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="mb-4 sm:mb-6 flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ route('journal-entries.quick-templates') }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
               style="background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%); color: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Jurnal Singkat</span>
            </a>
            <a href="{{ route('journal-entries.create') }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
               style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%); color: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Buat Jurnal Baru</span>
            </a>
        </div>        <!-- Filter Toggle Button -->
        <div class="mb-4 sm:mb-6 flex justify-between items-center">
            <button type="button"
                    id="toggleFilter"
                    onclick="toggleFilterSection()"
                    class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md border"
                    style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg id="filterIcon" class="w-4 h-4 mr-2 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                </svg>
                <span id="filterText">Tampilkan Filter</span>
                <svg id="chevronIcon" class="w-3 h-3 ml-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Active Filters Summary (when filter section is hidden) -->
            <div id="activeFiltersSummary" class="hidden flex flex-wrap gap-2 items-center">
                @if(request()->hasAny(['no_jurnal', 'tanggal_dari', 'tanggal_sampai', 'keterangan', 'debit_min', 'debit_max']))
                    <span class="text-xs font-medium text-gray-500">Filter aktif:</span>

                    @if(request('no_jurnal'))
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                            No: {{ request('no_jurnal') }}
                        </span>
                    @endif

                    @if(request('tanggal_dari') || request('tanggal_sampai'))
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                            {{ request('tanggal_dari') ? date('d/m/Y', strtotime(request('tanggal_dari'))) : '...' }} - {{ request('tanggal_sampai') ? date('d/m/Y', strtotime(request('tanggal_sampai'))) : '...' }}
                        </span>
                    @endif

                    @if(request('keterangan'))
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                            {{ Str::limit(request('keterangan'), 15) }}
                        </span>
                    @endif

                    @if(request('debit_min') || request('debit_max'))
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">
                            Rp {{ request('debit_min') ? number_format(request('debit_min')) : '0' }} - {{ request('debit_max') ? number_format(request('debit_max')) : '∞' }}
                        </span>
                    @endif
                @endif
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div id="filterSection" class="mb-4 sm:mb-6 bg-white rounded-xl shadow-lg border p-4 sm:p-6 hidden" style="border-color: #E2E8F0;">
            <form method="GET" action="{{ route('journal-entries.index') }}" class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold" style="color: #0F172A;">Filter & Pencarian</h3>
                    </div>

                    <!-- Reset & Apply Buttons -->
                    <div class="flex gap-2">
                        <a href="{{ route('journal-entries.index') }}"
                           class="inline-flex items-center px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 border hover:shadow-md"
                           style="color: #64748B; border-color: #E2E8F0; background: white;">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-xs font-medium text-white transition-all duration-200 hover:shadow-md"
                                style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>
                    </div>
                </div>

                <!-- Search Fields Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3 sm:gap-4">
                    <!-- No Jurnal Search -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #374151;">No. Jurnal</label>
                        <input type="text"
                               name="no_jurnal"
                               value="{{ request('no_jurnal') }}"
                               placeholder="Cari no jurnal..."
                               class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>

                    <!-- Tanggal Dari -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #374151;">Tanggal Dari</label>
                        <input type="date"
                               name="tanggal_dari"
                               value="{{ request('tanggal_dari') }}"
                               class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>

                    <!-- Tanggal Sampai -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #374151;">Tanggal Sampai</label>
                        <input type="date"
                               name="tanggal_sampai"
                               value="{{ request('tanggal_sampai') }}"
                               class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>

                    <!-- Keterangan Search -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #374151;">Keterangan</label>
                        <input type="text"
                               name="keterangan"
                               value="{{ request('keterangan') }}"
                               placeholder="Cari keterangan..."
                               class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>

                    <!-- Total Debit Min -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #374151;">Debit Min</label>
                        <input type="number"
                               name="debit_min"
                               value="{{ request('debit_min') }}"
                               placeholder="0"
                               min="0"
                               step="1000"
                               class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>

                    <!-- Total Debit Max -->
                    <div>
                        <label class="block text-xs font-medium mb-1" style="color: #374151;">Debit Max</label>
                        <input type="number"
                               name="debit_max"
                               value="{{ request('debit_max') }}"
                               placeholder="999999999"
                               min="0"
                               step="1000"
                               class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>
                </div>

                <!-- Quick Filter Buttons -->
                <div class="flex flex-wrap gap-2 pt-2 border-t border-gray-200">
                    <span class="text-xs font-medium text-gray-500 mr-2">Filter Cepat:</span>
                    <button type="button" onclick="setDateFilter('today')"
                            class="px-3 py-1 text-xs rounded-md border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        Hari Ini
                    </button>
                    <button type="button" onclick="setDateFilter('week')"
                            class="px-3 py-1 text-xs rounded-md border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        Minggu Ini
                    </button>
                    <button type="button" onclick="setDateFilter('month')"
                            class="px-3 py-1 text-xs rounded-md border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        Bulan Ini
                    </button>
                    <button type="button" onclick="setDateFilter('year')"
                            class="px-3 py-1 text-xs rounded-md border border-gray-300 hover:bg-gray-50 transition-colors duration-200">
                        Tahun Ini
                    </button>
                </div>

                <!-- Active Filters Display -->
                @if(request()->hasAny(['no_jurnal', 'tanggal_dari', 'tanggal_sampai', 'keterangan', 'debit_min', 'debit_max']))
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-200">
                        <span class="text-xs font-medium text-gray-500">Filter Aktif:</span>

                        @if(request('no_jurnal'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                No: {{ request('no_jurnal') }}
                                <button type="button" onclick="clearFilter('no_jurnal')" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                            </span>
                        @endif

                        @if(request('tanggal_dari') || request('tanggal_sampai'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                                Tanggal: {{ request('tanggal_dari') ? date('d/m/Y', strtotime(request('tanggal_dari'))) : '...' }} - {{ request('tanggal_sampai') ? date('d/m/Y', strtotime(request('tanggal_sampai'))) : '...' }}
                                <button type="button" onclick="clearDateFilter()" class="ml-1 text-green-600 hover:text-green-800">×</button>
                            </span>
                        @endif

                        @if(request('keterangan'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                                Keterangan: {{ Str::limit(request('keterangan'), 20) }}
                                <button type="button" onclick="clearFilter('keterangan')" class="ml-1 text-purple-600 hover:text-purple-800">×</button>
                            </span>
                        @endif

                        @if(request('debit_min') || request('debit_max'))
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">
                                Debit: {{ request('debit_min') ? number_format(request('debit_min')) : '0' }} - {{ request('debit_max') ? number_format(request('debit_max')) : '∞' }}
                                <button type="button" onclick="clearAmountFilter()" class="ml-1 text-orange-600 hover:text-orange-800">×</button>
                            </span>
                        @endif
                    </div>
                @endif
            </form>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg border overflow-hidden" style="border-color: #E2E8F0;">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold" style="color: #0F172A;">Daftar Jurnal Umum</h3>
                    </div>
                    <div class="text-sm" style="color: #64748B;">
                        Total: {{ $journalEntries->total() }} jurnal
                    </div>
                </div>
            </div>

            <!-- Table -->
            @if($journalEntries->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y" style="divide-color: #E2E8F0;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">No. Jurnal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Keterangan</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Total Debit</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Total Kredit</th>
                                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="divide-color: #E2E8F0;">
                            @foreach($journalEntries as $entry)
                                <tr class="hover:bg-slate-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium" style="color: #0F172A;">{{ $entry->no_jurnal }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm" style="color: #334155;">{{ $entry->tanggal->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm" style="color: #334155;">{{ Str::limit($entry->keterangan, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm font-medium" style="color: #059669;">Rp {{ number_format($entry->total_debet, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm font-medium" style="color: #DC2626;">Rp {{ number_format($entry->total_kredit, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('journal-entries.show', $entry) }}"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-all duration-200 hover:scale-105"
                                               style="background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);"
                                               title="Lihat Detail">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('journal-entries.edit', $entry) }}"
                                               class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-all duration-200 hover:scale-105"
                                               style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);"
                                               title="Edit">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('journal-entries.destroy', $entry) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-all duration-200 hover:scale-105"
                                                        style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);"
                                                        title="Hapus">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($journalEntries->hasPages())
                    <div class="px-6 py-4 border-t" style="border-color: #E2E8F0; background: #F8FAFC;">
                        {{ $journalEntries->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #F1F5F9 0%, #E2E8F0 100%);">
                        <svg class="w-12 h-12" style="color: #94A3B8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium mb-2" style="color: #64748B;">Belum ada jurnal umum</h3>
                    <p class="text-sm mb-6" style="color: #94A3B8;">Mulai dengan membuat jurnal umum pertama Anda</p>
                    <a href="{{ route('journal-entries.create') }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all duration-200 transform hover:scale-105"
                       style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Jurnal Baru
                    </a>
                </div>
            @endif
        </div>
    </div>    <!-- JavaScript untuk Filter Functionality -->
    <script>
        // Toggle filter section visibility
        function toggleFilterSection() {
            const filterSection = document.getElementById('filterSection');
            const filterText = document.getElementById('filterText');
            const chevronIcon = document.getElementById('chevronIcon');
            const activeFiltersSummary = document.getElementById('activeFiltersSummary');
            const toggleButton = document.getElementById('toggleFilter');

            if (filterSection.classList.contains('hidden')) {
                // Show filter section
                filterSection.classList.remove('hidden');
                filterSection.style.animation = 'slideDown 0.3s ease-out';
                filterText.textContent = 'Sembunyikan Filter';
                chevronIcon.style.transform = 'rotate(180deg)';
                activeFiltersSummary.classList.add('hidden');
                toggleButton.style.background = 'linear-gradient(135deg, #14B8A6 0%, #0F766E 100%)';
                toggleButton.style.color = 'white';
                toggleButton.style.borderColor = '#14B8A6';

                // Store state in localStorage
                localStorage.setItem('filterSectionVisible', 'true');
            } else {
                // Hide filter section
                filterSection.style.animation = 'slideUp 0.3s ease-out';
                setTimeout(() => {
                    filterSection.classList.add('hidden');
                }, 250);
                filterText.textContent = 'Tampilkan Filter';
                chevronIcon.style.transform = 'rotate(0deg)';

                // Show active filters summary if any filters are active
                @if(request()->hasAny(['no_jurnal', 'tanggal_dari', 'tanggal_sampai', 'keterangan', 'debit_min', 'debit_max']))
                    activeFiltersSummary.classList.remove('hidden');
                @endif

                toggleButton.style.background = 'white';
                toggleButton.style.color = '#64748B';
                toggleButton.style.borderColor = '#E2E8F0';

                // Store state in localStorage
                localStorage.setItem('filterSectionVisible', 'false');
            }
        }

        // Initialize filter section state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const filterSection = document.getElementById('filterSection');
            const filterText = document.getElementById('filterText');
            const chevronIcon = document.getElementById('chevronIcon');
            const activeFiltersSummary = document.getElementById('activeFiltersSummary');
            const toggleButton = document.getElementById('toggleFilter');

            // Check if there are active filters
            const hasActiveFilters = {{ request()->hasAny(['no_jurnal', 'tanggal_dari', 'tanggal_sampai', 'keterangan', 'debit_min', 'debit_max']) ? 'true' : 'false' }};

            // Get saved state from localStorage, default to showing if there are active filters
            const savedState = localStorage.getItem('filterSectionVisible');
            const shouldShow = savedState ? savedState === 'true' : hasActiveFilters;

            if (shouldShow) {
                filterSection.classList.remove('hidden');
                filterText.textContent = 'Sembunyikan Filter';
                chevronIcon.style.transform = 'rotate(180deg)';
                toggleButton.style.background = 'linear-gradient(135deg, #14B8A6 0%, #0F766E 100%)';
                toggleButton.style.color = 'white';
                toggleButton.style.borderColor = '#14B8A6';
                activeFiltersSummary.classList.add('hidden');
            } else {
                filterSection.classList.add('hidden');
                filterText.textContent = 'Tampilkan Filter';
                chevronIcon.style.transform = 'rotate(0deg)';
                if (hasActiveFilters) {
                    activeFiltersSummary.classList.remove('hidden');
                }
            }
        });

        // Quick date filter functions
        function setDateFilter(period) {
            const today = new Date();
            const tanggalDariInput = document.querySelector('input[name="tanggal_dari"]');
            const tanggalSampaiInput = document.querySelector('input[name="tanggal_sampai"]');

            let startDate, endDate;

            switch(period) {
                case 'today':
                    startDate = endDate = today.toISOString().split('T')[0];
                    break;
                case 'week':
                    const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                    const lastDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay() + 6));
                    startDate = firstDayOfWeek.toISOString().split('T')[0];
                    endDate = lastDayOfWeek.toISOString().split('T')[0];
                    break;
                case 'month':
                    startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                    endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
                    break;
                case 'year':
                    startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                    endDate = new Date(today.getFullYear(), 11, 31).toISOString().split('T')[0];
                    break;
            }

            tanggalDariInput.value = startDate;
            tanggalSampaiInput.value = endDate;
        }

        // Clear individual filter functions
        function clearFilter(filterName) {
            const input = document.querySelector(`input[name="${filterName}"]`);
            if (input) {
                input.value = '';
                input.form.submit();
            }
        }

        function clearDateFilter() {
            document.querySelector('input[name="tanggal_dari"]').value = '';
            document.querySelector('input[name="tanggal_sampai"]').value = '';
            document.querySelector('form').submit();
        }

        function clearAmountFilter() {
            document.querySelector('input[name="debit_min"]').value = '';
            document.querySelector('input[name="debit_max"]').value = '';
            document.querySelector('form').submit();
        }

        // Auto-submit form on Enter key for search inputs
        document.querySelectorAll('input[type="text"], input[type="number"]').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.form.submit();
                }
            });
        });

        // Auto-submit form when date inputs change
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.addEventListener('change', function() {
                // Add small delay to allow user to set both dates before submitting
                setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        });

        // Format number inputs for better UX
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value) {
                    const value = parseInt(this.value);
                    if (!isNaN(value)) {
                        this.value = value;
                    }
                }
            });
        });

        // Show loading state when form is submitted
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = `
                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Mencari...
                `;
                submitBtn.disabled = true;
            }
        });

        // Add tooltip for better UX
        document.querySelectorAll('[title]').forEach(element => {
            element.addEventListener('mouseenter', function() {
                this.style.cursor = 'help';
            });
        });
    </script>

    <!-- CSS Animations -->
    <style>
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
                max-height: 0;
            }
            to {
                opacity: 1;
                transform: translateY(0);
                max-height: 500px;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0);
                max-height: 500px;
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
                max-height: 0;
            }
        }

        #filterSection {
            overflow: hidden;
            transition: all 0.3s ease-out;
        }

        #toggleFilter:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #activeFiltersSummary .inline-flex {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</x-admin-layout>
