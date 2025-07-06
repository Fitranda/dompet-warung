@section('title', 'Tambah Saldo Awal')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Tambah Saldo Awal</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <span class="truncate">Set saldo awal untuk akun</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
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
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Form Saldo Awal</h3>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('opening-balances.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Account Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="account_id" class="block text-sm font-medium mb-2" style="color: #374151;">
                            Pilih Akun <span class="text-red-500">*</span>
                        </label>
                        <select name="account_id" id="account_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                required>
                            <option value="">-- Pilih Akun --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('account_id') == $account->id ? 'selected' : '' }}>
                                    {{ $account->kode_akun }} - {{ $account->nama_akun }}
                                </option>
                            @endforeach
                        </select>
                        @error('account_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bulan" class="block text-sm font-medium mb-2" style="color: #374151;">
                            Bulan <span class="text-red-500">*</span>
                        </label>
                        <input type="month"
                               name="bulan"
                               id="bulan"
                               value="{{ old('bulan', date('Y-m')) }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               required>
                        @error('bulan')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Amount -->
                <div>
                    <label for="saldo_awal" class="block text-sm font-medium mb-2" style="color: #374151;">
                        Saldo Awal <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number"
                               name="saldo_awal"
                               id="saldo_awal"
                               value="{{ old('saldo_awal') }}"
                               placeholder="0"
                               min="0"
                               step="0.01"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               required>
                    </div>
                    @error('saldo_awal')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Account Info Display -->
                <div id="accountInfo" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">Informasi Akun:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-blue-600 font-medium">Kode:</span>
                            <span id="accountCode" class="text-blue-800"></span>
                        </div>
                        <div>
                            <span class="text-blue-600 font-medium">Nama:</span>
                            <span id="accountName" class="text-blue-800"></span>
                        </div>
                        <div>
                            <span class="text-blue-600 font-medium">Tipe:</span>
                            <span id="accountType" class="text-blue-800"></span>
                        </div>
                        <div>
                            <span class="text-blue-600 font-medium">Saldo Normal:</span>
                            <span id="normalBalance" class="text-blue-800"></span>
                        </div>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-amber-800">Tips Saldo Awal:</h3>
                            <div class="mt-2 text-sm text-amber-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Saldo awal adalah posisi saldo akun di awal periode</li>
                                    <li>Untuk akun <strong>Aset</strong> dan <strong>Beban</strong>: saldo normal di <em>Debit</em></li>
                                    <li>Untuk akun <strong>Liabilitas</strong>, <strong>Ekuitas</strong>, dan <strong>Pendapatan</strong>: saldo normal di <em>Kredit</em></li>
                                    <li>Masukkan nilai absolut (tanpa tanda minus)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Saldo Awal
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
        // Account data for info display
        @php
            $accountsData = $accounts->map(function($account) {
                $debitAccounts = ['aset', 'beban'];
                $normalBalance = in_array($account->tipe_akun, $debitAccounts) ? 'Debit' : 'Kredit';
                return [
                    'id' => $account->id,
                    'kode_akun' => $account->kode_akun,
                    'nama_akun' => $account->nama_akun,
                    'tipe_akun' => $account->tipe_akun,
                    'normal_balance' => $normalBalance
                ];
            });
        @endphp
        const accounts = {!! json_encode($accountsData) !!};

        // Show account info when account is selected
        document.getElementById('account_id').addEventListener('change', function() {
            const accountInfo = document.getElementById('accountInfo');
            const selectedId = this.value;

            if (selectedId) {
                const account = accounts.find(acc => acc.id == selectedId);
                if (account) {
                    document.getElementById('accountCode').textContent = account.kode_akun;
                    document.getElementById('accountName').textContent = account.nama_akun;
                    document.getElementById('accountType').textContent = account.tipe_akun.charAt(0).toUpperCase() + account.tipe_akun.slice(1);
                    document.getElementById('normalBalance').textContent = account.normal_balance;
                    accountInfo.classList.remove('hidden');
                }
            } else {
                accountInfo.classList.add('hidden');
            }
        });

        // Format number input
        document.getElementById('saldo_awal').addEventListener('input', function() {
            // Remove non-numeric characters except dots
            this.value = this.value.replace(/[^0-9.]/g, '');

            // Ensure only one decimal point
            const parts = this.value.split('.');
            if (parts.length > 2) {
                this.value = parts[0] + '.' + parts.slice(1).join('');
            }
        });

        // Auto-select account if there's only one option
        document.addEventListener('DOMContentLoaded', function() {
            const accountSelect = document.getElementById('account_id');
            if (accountSelect.options.length === 2) { // Only default option and one account
                accountSelect.selectedIndex = 1;
                accountSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-admin-layout>
