<x-admin-layout>
    <x-slot name="title">
        Neraca
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Neraca (Balance Sheet)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <div class="mb-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Filter Laporan</h3>
                            <button type="button"
                                onclick="toggleFilters()"
                                class="text-sm text-indigo-600 hover:text-indigo-500">
                                <span id="filter-toggle-text">Sembunyikan Filter</span>
                                <svg id="filter-toggle-icon" class="w-5 h-5 inline-block ml-1 transform transition-transform duration-200"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>

                        <div id="filter-panel" class="transition-all duration-300">
                            <form method="GET" action="{{ route('reports.balance-sheet') }}" class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- End Date -->
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                                            Per Tanggal
                                        </label>
                                        <input type="date"
                                               name="end_date"
                                               id="end_date"
                                               value="{{ $endDate }}"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>

                                    <!-- Include Detail -->
                                    <div class="flex items-center justify-center">
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                   name="include_detail"
                                                   value="1"
                                                   {{ $includeDetail ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Tampilkan Detail Transaksi</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-3">
                                        <button type="submit"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            Filter
                                        </button>

                                        <a href="{{ route('reports.balance-sheet') }}"
                                           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Reset
                                        </a>
                                    </div>

                                    <!-- Export Buttons -->
                                    <div class="flex space-x-2">
                                        <button type="button"
                                                onclick="exportToPdf()"
                                                class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            PDF
                                        </button>

                                        <button type="button"
                                                onclick="exportToExcel()"
                                                class="inline-flex items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Excel
                                        </button>

                                        <button type="button"
                                                onclick="window.print()"
                                                class="inline-flex items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Print
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Content -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white">
                    <!-- Report Header -->
                    <div class="text-center mb-8 print:mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 print:text-xl">
                            {{ Auth::user()->umkm->nama ?? 'UMKM' }}
                        </h1>
                        <h2 class="text-xl font-semibold text-gray-700 mt-2 print:text-lg">
                            NERACA (BALANCE SHEET)
                        </h2>
                        <p class="text-gray-600 mt-1 print:text-sm">
                            Per Tanggal: {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
                        </p>
                    </div>

                    <!-- Assets Section -->
                    <div class="mb-8">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">ASET</h3>
                        </div>

                        @if(count($assetData) > 0)
                            <div class="space-y-2">
                                @foreach($assetData as $asset)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <div class="flex-1">
                                            <span class="text-gray-900">{{ $asset['account']->kode_akun }} - {{ $asset['account']->nama_akun }}</span>
                                        </div>
                                        <div class="text-right min-w-32">
                                            <span class="font-mono text-gray-900">
                                                {{ number_format(abs($asset['balance']), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($includeDetail && count($asset['details']) > 0)
                                        <div class="ml-8 mb-4">
                                            <div class="bg-gray-50 rounded-lg p-3">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Detail Transaksi:</h5>
                                                <div class="space-y-1 text-sm">
                                                    @foreach($asset['details'] as $detail)
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">
                                                                {{ \Carbon\Carbon::parse($detail->tanggal)->format('d/m/Y') }} -
                                                                {{ $detail->no_jurnal }}
                                                            </span>
                                                            <span class="font-mono text-gray-700">
                                                                {{ number_format($detail->debet - $detail->kredit, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="flex justify-between items-center py-3 border-t-2 border-gray-400 mt-4">
                                <span class="font-semibold text-gray-900">Total Aset</span>
                                <span class="font-semibold font-mono text-gray-900">
                                    {{ number_format(abs($totalAssets), 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>Tidak ada data aset untuk tanggal ini.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Liabilities Section -->
                    <div class="mb-8">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">LIABILITAS</h3>
                        </div>

                        @if(count($liabilityData) > 0)
                            <div class="space-y-2">
                                @foreach($liabilityData as $liability)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <div class="flex-1">
                                            <span class="text-gray-900">{{ $liability['account']->kode_akun }} - {{ $liability['account']->nama_akun }}</span>
                                        </div>
                                        <div class="text-right min-w-32">
                                            <span class="font-mono text-gray-900">
                                                {{ number_format(abs($liability['balance']), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($includeDetail && count($liability['details']) > 0)
                                        <div class="ml-8 mb-4">
                                            <div class="bg-gray-50 rounded-lg p-3">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Detail Transaksi:</h5>
                                                <div class="space-y-1 text-sm">
                                                    @foreach($liability['details'] as $detail)
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">
                                                                {{ \Carbon\Carbon::parse($detail->tanggal)->format('d/m/Y') }} -
                                                                {{ $detail->no_jurnal }}
                                                            </span>
                                                            <span class="font-mono text-gray-700">
                                                                {{ number_format($detail->kredit - $detail->debet, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="flex justify-between items-center py-3 border-t-2 border-gray-400 mt-4">
                                <span class="font-semibold text-gray-900">Total Liabilitas</span>
                                <span class="font-semibold font-mono text-gray-900">
                                    {{ number_format(abs($totalLiabilities), 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>Tidak ada data liabilitas untuk tanggal ini.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Equity Section -->
                    <div class="mb-8">
                        <div class="border-b-2 border-gray-300 pb-2 mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">EKUITAS</h3>
                        </div>

                        @if(count($equityData) > 0 || $retainedEarnings != 0)
                            <div class="space-y-2">
                                @foreach($equityData as $equity)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <div class="flex-1">
                                            <span class="text-gray-900">{{ $equity['account']->kode_akun }} - {{ $equity['account']->nama_akun }}</span>
                                        </div>
                                        <div class="text-right min-w-32">
                                            <span class="font-mono text-gray-900">
                                                {{ number_format(abs($equity['balance']), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($includeDetail && count($equity['details']) > 0)
                                        <div class="ml-8 mb-4">
                                            <div class="bg-gray-50 rounded-lg p-3">
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Detail Transaksi:</h5>
                                                <div class="space-y-1 text-sm">
                                                    @foreach($equity['details'] as $detail)
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600">
                                                                {{ \Carbon\Carbon::parse($detail->tanggal)->format('d/m/Y') }} -
                                                                {{ $detail->no_jurnal }}
                                                            </span>
                                                            <span class="font-mono text-gray-700">
                                                                {{ number_format($detail->kredit - $detail->debet, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                                @if($retainedEarnings != 0)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                        <div class="flex-1">
                                            <span class="text-gray-900">Saldo Laba Ditahan</span>
                                        </div>
                                        <div class="text-right min-w-32">
                                            <span class="font-mono text-gray-900">
                                                {{ number_format(abs($retainedEarnings), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="flex justify-between items-center py-3 border-t-2 border-gray-400 mt-4">
                                <span class="font-semibold text-gray-900">Total Ekuitas</span>
                                <span class="font-semibold font-mono text-gray-900">
                                    {{ number_format(abs($totalEquity), 0, ',', '.') }}
                                </span>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>Tidak ada data ekuitas untuk tanggal ini.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Total Liabilities + Equity -->
                    <div class="border-t-4 border-gray-600 pt-6 mb-6">
                        <div class="flex justify-between items-center py-4 bg-gray-50 px-4 rounded-lg">
                            <span class="text-xl font-bold text-gray-900">
                                TOTAL LIABILITAS + EKUITAS
                            </span>
                            <span class="text-xl font-bold font-mono text-gray-900">
                                {{ number_format(abs($totalLiabilitiesEquity), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Balance Check -->
                    <div class="border-2 {{ $isBalanced ? 'border-green-400 bg-green-50' : 'border-red-400 bg-red-50' }} rounded-lg p-4">
                        <h4 class="font-bold text-lg {{ $isBalanced ? 'text-green-800' : 'text-red-800' }} mb-2">
                            Pengecekan Neraca
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <strong>Total Aset:</strong> {{ number_format(abs($totalAssets), 0, ',', '.') }}
                            </div>
                            <div>
                                <strong>Total Liabilitas + Ekuitas:</strong> {{ number_format(abs($totalLiabilitiesEquity), 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="mt-2 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $isBalanced ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                @if($isBalanced)
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    NERACA SEIMBANG
                                @else
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    NERACA TIDAK SEIMBANG
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Summary Info -->
                    <div class="mt-8 pt-6 border-t border-gray-200 text-sm text-gray-600 print:hidden">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <strong>Total Akun Aset:</strong> {{ count($assetData) }}
                            </div>
                            <div>
                                <strong>Total Akun Liabilitas:</strong> {{ count($liabilityData) }}
                            </div>
                            <div>
                                <strong>Total Akun Ekuitas:</strong> {{ count($equityData) }}
                            </div>
                        </div>
                        <div class="mt-2">
                            <strong>Dibuat pada:</strong> {{ now()->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            .print\:hidden { display: none !important; }
            .print\:text-xl { font-size: 1.25rem !important; }
            .print\:text-lg { font-size: 1.125rem !important; }
            .print\:text-sm { font-size: 0.875rem !important; }
            .print\:mb-6 { margin-bottom: 1.5rem !important; }

            body { font-size: 12px; }
            .max-w-7xl { max-width: none; }
            .px-6, .sm\:px-6, .lg\:px-8 { padding-left: 0; padding-right: 0; }
            .py-12 { padding-top: 0; padding-bottom: 0; }
            .shadow-xl, .shadow-sm { box-shadow: none; }
        }
    </style>

    <!-- JavaScript -->
    <script>
        function toggleFilters() {
            const panel = document.getElementById('filter-panel');
            const icon = document.getElementById('filter-toggle-icon');
            const text = document.getElementById('filter-toggle-text');

            if (panel.style.display === 'none') {
                panel.style.display = 'block';
                icon.style.transform = 'rotate(0deg)';
                text.textContent = 'Sembunyikan Filter';
            } else {
                panel.style.display = 'none';
                icon.style.transform = 'rotate(-90deg)';
                text.textContent = 'Tampilkan Filter';
            }
        }

        function exportToPdf() {
            const endDate = document.getElementById('end_date').value;
            const includeDetail = document.querySelector('input[name="include_detail"]').checked ? '1' : '0';

            const url = `{{ route('reports.balance-sheet.export.pdf') }}?end_date=${endDate}&include_detail=${includeDetail}`;
            window.open(url, '_blank');
        }

        function exportToExcel() {
            const endDate = document.getElementById('end_date').value;
            const includeDetail = document.querySelector('input[name="include_detail"]').checked ? '1' : '0';

            const url = `{{ route('reports.balance-sheet.export.excel') }}?end_date=${endDate}&include_detail=${includeDetail}`;
            window.location.href = url;
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                switch(e.key) {
                    case 'p':
                        e.preventDefault();
                        window.print();
                        break;
                    case 'e':
                        e.preventDefault();
                        exportToExcel();
                        break;
                    case 'd':
                        e.preventDefault();
                        exportToPdf();
                        break;
                }
            }
        });
    </script>
</x-admin-layout>
