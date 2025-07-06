@section('title', 'Detail Saldo Awal')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Detail Saldo Awal</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="truncate">Informasi lengkap saldo awal akun</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
        <!-- Navigation -->
        <div class="mb-4 sm:mb-6 flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ route('opening-balances.index') }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-md border"
               style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            <a href="{{ route('opening-balances.edit', $openingBalance) }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
               style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
        </div>

        <!-- Main Detail Card -->
        <div class="bg-white rounded-xl shadow-lg border overflow-hidden" style="border-color: #E2E8F0;">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Informasi Saldo Awal</h3>
                </div>
            </div>

            <!-- Detail Content -->
            <div class="p-6 space-y-6">
                <!-- Account Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-blue-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Informasi Akun
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-blue-600">Kode Akun:</label>
                                <p class="text-blue-800 font-semibold">{{ $openingBalance->account->kode_akun }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-600">Nama Akun:</label>
                                <p class="text-blue-800 font-semibold">{{ $openingBalance->account->nama_akun }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-blue-600">Tipe Akun:</label>
                                <p class="text-blue-800 font-semibold">{{ ucfirst($openingBalance->account->tipe_akun) }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-600">Saldo Normal:</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ in_array($openingBalance->account->tipe_akun, ['aset', 'beban']) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ in_array($openingBalance->account->tipe_akun, ['aset', 'beban']) ? 'Debit' : 'Kredit' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance Information -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        Informasi Saldo
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-600">Tahun:</label>
                            <p class="text-2xl font-bold text-green-800">{{ $openingBalance->tahun }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-600">Saldo Awal:</label>
                            <p class="text-2xl font-bold text-green-800">Rp {{ number_format($openingBalance->saldo_awal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- System Information -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Sistem
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="block font-medium text-gray-600">Dibuat pada:</label>
                            <p class="text-gray-800">{{ $openingBalance->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block font-medium text-gray-600">Terakhir diupdate:</label>
                            <p class="text-gray-800">{{ $openingBalance->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h4>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('opening-balances.edit', $openingBalance) }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
                           style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Saldo
                        </a>
                        <form action="{{ route('opening-balances.destroy', $openingBalance) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus saldo awal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
                                    style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                        <a href="{{ route('opening-balances.create') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-md hover:scale-[1.02]"
                           style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Saldo Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-800">Catatan Penting:</h3>
                    <div class="mt-2 text-sm text-amber-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Saldo awal ini akan digunakan sebagai dasar perhitungan laporan keuangan</li>
                            <li>Perubahan pada saldo awal akan mempengaruhi neraca awal dan laporan lainnya</li>
                            <li>Pastikan saldo awal sesuai dengan catatan keuangan sebelumnya</li>
                            <li>Untuk akun <strong>{{ ucfirst($openingBalance->account->tipe_akun) }}</strong>, saldo normal berada di sisi
                                <em>{{ in_array($openingBalance->account->tipe_akun, ['aset', 'beban']) ? 'Debit' : 'Kredit' }}</em>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
