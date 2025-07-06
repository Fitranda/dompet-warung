@section('title', 'Input Massal Saldo Awal')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Input Massal Saldo Awal</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="truncate">Set saldo awal untuk beberapa akun sekaligus</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
        <!-- Navigation -->
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('opening-balances.index') }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md border"
               style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <h3 class="text-xs sm:text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                        <div class="mt-2 text-xs sm:text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-lg border overflow-hidden" style="border-color: #E2E8F0;">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold" style="color: #0F172A;">Form Input Massal</h3>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" onclick="selectAll()"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 border hover:shadow-md"
                                style="color: #64748B; border-color: #E2E8F0; background: white;">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pilih Semua
                        </button>
                        <button type="button" onclick="clearAll()"
                                class="inline-flex items-center px-3 py-2 rounded-lg text-xs font-medium transition-all duration-200 border hover:shadow-md"
                                style="color: #64748B; border-color: #E2E8F0; background: white;">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Bersihkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('opening-balances.bulk-store') }}" method="POST" class="p-6">
                @csrf

                <!-- Month Selection -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <label for="bulan" class="block text-sm font-medium mb-2" style="color: #374151;">
                        Bulan Saldo Awal <span class="text-red-500">*</span>
                    </label>
                    <input type="month"
                           name="bulan"
                           id="bulan"
                           value="{{ old('bulan', date('Y-m')) }}"
                           class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                           required>
                </div>

                <!-- Search and Filter -->
                <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text"
                                   id="searchAccounts"
                                   placeholder="Cari akun (kode atau nama)..."
                                   class="w-full px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <select id="filterAccountType"
                                    class="w-full sm:w-auto px-4 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Tipe</option>
                                <option value="aset">Aset</option>
                                <option value="liabilitas">Liabilitas</option>
                                <option value="ekuitas">Ekuitas</option>
                                <option value="pendapatan">Pendapatan</option>
                                <option value="beban">Beban</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Accounts Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y" style="divide-color: #E2E8F0;">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">
                                    <input type="checkbox" id="selectAllCheckbox" onchange="toggleAllAccounts()" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Kode Akun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Nama Akun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Saldo Normal</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Saldo Awal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="divide-color: #E2E8F0;" id="accountsTableBody">
                            @foreach($accounts as $account)
                                <tr class="account-row hover:bg-slate-50 transition-colors duration-200"
                                    data-account-type="{{ $account->tipe_akun }}"
                                    data-search-text="{{ strtolower($account->kode_akun . ' ' . $account->nama_akun) }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox"
                                               name="selected_accounts[]"
                                               value="{{ $account->id }}"
                                               class="account-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                               onchange="toggleAccountRow(this)">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium" style="color: #0F172A;">{{ $account->kode_akun }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm" style="color: #334155;">{{ $account->nama_akun }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($account->tipe_akun == 'aset') bg-blue-100 text-blue-800
                                            @elseif($account->tipe_akun == 'liabilitas') bg-red-100 text-red-800
                                            @elseif($account->tipe_akun == 'ekuitas') bg-purple-100 text-purple-800
                                            @elseif($account->tipe_akun == 'pendapatan') bg-green-100 text-green-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ ucfirst($account->tipe_akun) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ in_array($account->tipe_akun, ['aset', 'beban']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ in_array($account->tipe_akun, ['aset', 'beban']) ? 'Debit' : 'Kredit' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <input type="hidden"
                                               name="opening_balances[{{ $account->id }}][account_id]"
                                               value="{{ $account->id }}">
                                        <input type="number"
                                               name="opening_balances[{{ $account->id }}][saldo_awal]"
                                               placeholder="0"
                                               min="0"
                                               step="0.01"
                                               disabled
                                               class="w-32 px-3 py-2 text-sm text-right border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100 disabled:text-gray-400">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Selected Summary -->
                <div id="selectedSummary" class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-blue-800">Akun Terpilih:</h4>
                            <p class="text-sm text-blue-600"><span id="selectedCount">0</span> akun dipilih</p>
                        </div>
                        <div class="text-right">
                            <h4 class="text-sm font-medium text-blue-800">Total Saldo:</h4>
                            <p class="text-sm font-semibold text-blue-800" id="totalAmount">Rp 0</p>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-amber-800">Cara Penggunaan:</h3>
                            <div class="mt-2 text-sm text-amber-700">
                                <ol class="list-decimal list-inside space-y-1">
                                    <li>Pilih bulan untuk saldo awal</li>
                                    <li>Gunakan fitur pencarian untuk menemukan akun dengan cepat</li>
                                    <li>Centang akun yang ingin diisi saldo awalnya</li>
                                    <li>Masukkan nilai saldo awal (dalam rupiah)</li>
                                    <li>Klik "Simpan Semua" untuk menyimpan data</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Semua Saldo Awal
                    </button>
                    <a href="{{ route('opening-balances.index') }}"
                       class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md border"
                       style="color: #64748B; border-color: #E2E8F0; background: white;">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Search functionality
        document.getElementById('searchAccounts').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterAccounts();
        });

        // Filter by account type
        document.getElementById('filterAccountType').addEventListener('change', function() {
            filterAccounts();
        });

        function filterAccounts() {
            const searchTerm = document.getElementById('searchAccounts').value.toLowerCase();
            const accountType = document.getElementById('filterAccountType').value;
            const rows = document.querySelectorAll('.account-row');

            rows.forEach(row => {
                const searchText = row.getAttribute('data-search-text');
                const rowAccountType = row.getAttribute('data-account-type');

                const matchesSearch = searchText.includes(searchTerm);
                const matchesType = !accountType || rowAccountType === accountType;

                if (matchesSearch && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Toggle all accounts
        function toggleAllAccounts() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const visibleCheckboxes = document.querySelectorAll('.account-row:not([style*="display: none"]) .account-checkbox');

            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                toggleAccountRow(checkbox);
            });

            updateSelectedSummary();
        }

        // Toggle individual account row
        function toggleAccountRow(checkbox) {
            const row = checkbox.closest('tr');
            const amountInput = row.querySelector('input[type="number"]');

            if (checkbox.checked) {
                amountInput.disabled = false;
                amountInput.focus();
                row.classList.add('bg-blue-50');
            } else {
                amountInput.disabled = true;
                amountInput.value = '';
                row.classList.remove('bg-blue-50');
            }

            updateSelectedSummary();
        }

        // Update selected summary
        function updateSelectedSummary() {
            const selectedCheckboxes = document.querySelectorAll('.account-checkbox:checked');
            const selectedCount = selectedCheckboxes.length;
            const summaryDiv = document.getElementById('selectedSummary');
            const countSpan = document.getElementById('selectedCount');
            const totalSpan = document.getElementById('totalAmount');

            countSpan.textContent = selectedCount;

            let total = 0;
            selectedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const amountInput = row.querySelector('input[type="number"]');
                const amount = parseFloat(amountInput.value) || 0;
                total += amount;
            });

            totalSpan.textContent = 'Rp ' + total.toLocaleString('id-ID');

            if (selectedCount > 0) {
                summaryDiv.classList.remove('hidden');
            } else {
                summaryDiv.classList.add('hidden');
            }
        }

        // Add event listeners to amount inputs
        document.addEventListener('DOMContentLoaded', function() {
            const amountInputs = document.querySelectorAll('input[type="number"]');
            amountInputs.forEach(input => {
                input.addEventListener('input', updateSelectedSummary);

                // Format input
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9.]/g, '');
                    const parts = this.value.split('.');
                    if (parts.length > 2) {
                        this.value = parts[0] + '.' + parts.slice(1).join('');
                    }
                });
            });
        });

        // Select all helper functions
        function selectAll() {
            const visibleCheckboxes = document.querySelectorAll('.account-row:not([style*="display: none"]) .account-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');

            selectAllCheckbox.checked = true;
            visibleCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
                toggleAccountRow(checkbox);
            });

            updateSelectedSummary();
        }

        function clearAll() {
            const allCheckboxes = document.querySelectorAll('.account-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');

            selectAllCheckbox.checked = false;
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                toggleAccountRow(checkbox);
            });

            updateSelectedSummary();
        }
    </script>
</x-admin-layout>
