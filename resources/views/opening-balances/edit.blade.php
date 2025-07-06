@section('title', 'Edit Saldo Awal')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Edit Saldo Awal</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="truncate">Edit saldo awal {{ $openingBalance->account->nama_akun }}</span>
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
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Form Edit Saldo Awal</h3>
                </div>
            </div>

            <!-- Current Account Info -->
            <div class="px-6 py-4 bg-blue-50 border-b border-blue-200">
                <h4 class="text-sm font-medium text-blue-800 mb-2">Akun yang sedang diedit:</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm">
                    <div>
                        <span class="text-blue-600 font-medium">Kode:</span>
                        <span class="text-blue-800">{{ $openingBalance->account->kode_akun }}</span>
                    </div>
                    <div>
                        <span class="text-blue-600 font-medium">Nama:</span>
                        <span class="text-blue-800">{{ $openingBalance->account->nama_akun }}</span>
                    </div>
                    <div>
                        <span class="text-blue-600 font-medium">Tipe:</span>
                        <span class="text-blue-800">{{ ucfirst($openingBalance->account->tipe_akun) }}</span>
                    </div>
                    <div>
                        <span class="text-blue-600 font-medium">Tahun:</span>
                        <span class="text-blue-800">{{ $openingBalance->tahun }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('opening-balances.update', $openingBalance) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Hidden fields -->
                <input type="hidden" name="account_id" value="{{ $openingBalance->account_id }}">
                <input type="hidden" name="tahun" value="{{ $openingBalance->tahun }}">

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
                               value="{{ old('saldo_awal', $openingBalance->saldo_awal) }}"
                               placeholder="0"
                               min="0"
                               step="0.01"
                               class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               required>
                    </div>
                    @error('saldo_awal')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Saldo sebelumnya: <strong>Rp {{ number_format($openingBalance->saldo_awal, 0, ',', '.') }}</strong>
                    </p>
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
                            <h3 class="text-sm font-medium text-amber-800">Perhatian:</h3>
                            <div class="mt-2 text-sm text-amber-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Perubahan saldo awal akan mempengaruhi laporan keuangan</li>
                                    <li>Pastikan nilai yang dimasukkan sudah benar</li>
                                    <li>Akun <strong>{{ ucfirst($openingBalance->account->tipe_akun) }}</strong> memiliki saldo normal di
                                        <em>{{ in_array($openingBalance->account->tipe_akun, ['aset', 'beban']) ? 'Debit' : 'Kredit' }}</em>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button type="submit"
                            class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02]"
                            style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Saldo Awal
                    </button>
                    <a href="{{ route('opening-balances.show', $openingBalance) }}"
                       class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md border"
                       style="color: #64748B; border-color: #E2E8F0; background: white;">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </a>
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

        // Focus on amount input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('saldo_awal').focus();
            document.getElementById('saldo_awal').select();
        });
    </script>
</x-admin-layout>
