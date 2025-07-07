<x-admin-layout>
    <x-slot name="title">Buku Besar</x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">📊 Buku Besar</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2V7a2 2 0 012-2h2a2 2 0 002 2v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 00-2 2h-2a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="truncate">Laporan detail transaksi per akun</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Filter Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 no-print filter-section">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" style="color: #1E293B;">Filter Laporan</h3>
                    <button type="button" id="toggleFilter" class="text-teal-600 hover:text-teal-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </button>
                </div>

                <form method="GET" action="{{ route('reports.general-ledger') }}" id="filterForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date"
                                   id="start_date"
                                   name="start_date"
                                   value="{{ $startDate }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date"
                                   id="end_date"
                                   name="end_date"
                                   value="{{ $endDate }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                        </div>

                        <!-- Tipe Akun -->
                        <div>
                            <label for="tipe_akun" class="block text-sm font-medium text-gray-700 mb-2">Tipe Akun</label>
                            <select id="tipe_akun"
                                    name="tipe_akun"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                                <option value="">Semua Tipe</option>
                                <option value="aset" {{ $tipeAkun == 'aset' ? 'selected' : '' }}>💰 Aset</option>
                                <option value="liabilitas" {{ $tipeAkun == 'liabilitas' ? 'selected' : '' }}>💳 Liabilitas</option>
                                <option value="ekuitas" {{ $tipeAkun == 'ekuitas' ? 'selected' : '' }}>📊 Ekuitas</option>
                                <option value="pendapatan" {{ $tipeAkun == 'pendapatan' ? 'selected' : '' }}>📈 Pendapatan</option>
                                <option value="beban" {{ $tipeAkun == 'beban' ? 'selected' : '' }}>📉 Beban</option>
                            </select>
                        </div>

                        <!-- Akun Spesifik -->
                        <div>
                            <label for="account_id" class="block text-sm font-medium text-gray-700 mb-2">Akun Spesifik</label>
                            <select id="account_id"
                                    name="account_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                                <option value="">Semua Akun</option>
                                @foreach($allAccounts as $account)
                                    <option value="{{ $account->id }}" {{ $accountId == $account->id ? 'selected' : '' }}>
                                        {{ $account->kode_akun }} - {{ $account->nama_akun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 mt-6">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>

                        <a href="{{ route('reports.general-ledger') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset
                        </a>

                        <button type="button"
                                onclick="exportPdf()"
                                class="inline-flex items-center px-4 py-2 border border-red-300 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Export PDF
                        </button>

                        <button type="button"
                                onclick="exportExcel()"
                                class="inline-flex items-center px-4 py-2 border border-green-300 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-medium rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Info -->
        @if(count($ledgerData) > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H5m14 0v-2H3"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Total Akun</h3>
                            <p class="text-2xl font-bold">{{ count($ledgerData) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2V7a2 2 0 012-2h2a2 2 0 002 2v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 00-2 2h-2a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Periode</h3>
                            <p class="text-sm">{{ date('d/m/Y', strtotime($startDate)) }} - {{ date('d/m/Y', strtotime($endDate)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Total Transaksi</h3>
                            <p class="text-2xl font-bold">
                                {{ collect($ledgerData)->sum(function($data) { return count($data['entries']); }) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Ledger Content -->
        @if(count($ledgerData) > 0)
            @foreach($ledgerData as $data)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
                    <!-- Account Header -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">
                                    {{ $data['account']->kode_akun }} - {{ $data['account']->nama_akun }}
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">
                                    Tipe: <span class="font-medium">{{ ucfirst($data['account']->tipe_akun) }}</span>
                                    @if($data['account']->kategori)
                                        | Kategori: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $data['account']->kategori)) }}</span>
                                    @endif
                                </p>
                            </div>
                            <div class="mt-3 sm:mt-0 text-right">
                                <div class="text-sm text-gray-600">Saldo Normal:
                                    <span class="font-medium">{{ ucfirst($data['account']->saldo_normal) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ledger Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Jurnal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debet</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Kredit</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Opening Balance Row -->
                                <tr class="bg-blue-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        {{ date('d/m/Y', strtotime($startDate)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        -
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                        Saldo Awal
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        -
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        -
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right
                                        {{ $data['opening_balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format(abs($data['opening_balance']), 0, ',', '.') }}
                                        {{ $data['opening_balance'] < 0 ? '(-)' : '' }}
                                    </td>
                                </tr>

                                @php
                                    $runningBalance = $data['opening_balance'];
                                @endphp

                                @forelse($data['entries'] as $entry)
                                    @php
                                        // Calculate running balance based on account type
                                        if (in_array($data['account']->tipe_akun, ['aset', 'beban'])) {
                                            $runningBalance += ($entry->debet ?? 0) - ($entry->kredit ?? 0);
                                        } else {
                                            $runningBalance += ($entry->kredit ?? 0) - ($entry->debet ?? 0);
                                        }
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ date('d/m/Y', strtotime($entry->tanggal)) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $entry->no_jurnal }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $entry->keterangan ?: $entry->jurnal_keterangan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ $entry->debet ? number_format($entry->debet, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ $entry->kredit ? number_format($entry->kredit, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right
                                            {{ $runningBalance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format(abs($runningBalance), 0, ',', '.') }}
                                            {{ $runningBalance < 0 ? '(-)' : '' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Tidak ada transaksi dalam periode ini
                                        </td>
                                    </tr>
                                @endforelse

                                <!-- Closing Balance Row -->
                                <tr class="bg-green-50 font-medium">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                        {{ date('d/m/Y', strtotime($endDate)) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        -
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-bold">
                                        Saldo Akhir
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        -
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        -
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right
                                        {{ $data['closing_balance'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format(abs($data['closing_balance']), 0, ',', '.') }}
                                        {{ $data['closing_balance'] < 0 ? '(-)' : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada transaksi ditemukan dengan filter yang dipilih.</p>
                    <div class="mt-6">
                        <a href="{{ route('journal-entries.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Jurnal Baru
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')    <script>
        function printReport() {
            window.print();
        }

        function exportPdf() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            window.location.href = '{{ route("reports.general-ledger.export-pdf") }}?' + params.toString();
        }

        function exportExcel() {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            window.location.href = '{{ route("reports.general-ledger.export-excel") }}?' + params.toString();
        }

        // Auto submit on filter change
        document.addEventListener('DOMContentLoaded', function() {
            const filterInputs = ['start_date', 'end_date', 'tipe_akun', 'account_id'];

            filterInputs.forEach(function(inputId) {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('change', function() {
                        // Auto submit with delay for date inputs
                        if (inputId.includes('date')) {
                            setTimeout(() => {
                                document.getElementById('filterForm').submit();
                            }, 500);
                        } else {
                            document.getElementById('filterForm').submit();
                        }
                    });
                }
            });
        });
    </script>

    <style>
        @media print {
            .no-print, .bg-gradient-to-r form, .filter-section {
                display: none !important;
            }

            body {
                background: white !important;
                -webkit-print-color-adjust: exact;
            }

            .bg-gradient-to-r {
                background: #f9fafb !important;
                color: #111827 !important;
            }

            .shadow-sm {
                box-shadow: none !important;
            }

            .border {
                border: 1px solid #e5e7eb !important;
            }

            h1 {
                color: #111827 !important;
            }

            .text-teal-600, .text-green-600, .text-red-600 {
                color: #111827 !important;
            }
        }

        .filter-section {
            /* This will be hidden during print */
        }
    </style>
    @endpush
</x-admin-layout>
