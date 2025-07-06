@section('title', 'Jurnal Singkat')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Jurnal
                    Singkat</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="truncate">Pilih template jurnal yang sering digunakan</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
        <!-- Info Banner -->
        <div
            class="mb-4 sm:mb-6 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-3 sm:p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-3 flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-blue-900">Template Jurnal Siap Pakai</h3>
                    <p class="mt-1 text-xs sm:text-sm text-blue-700">
                        Pilih template sesuai jenis transaksi untuk mempercepat pencatatan jurnal umum. Template akan
                        mengisi akun debet dan kredit secara otomatis.
                    </p>
                    <div class="mt-2 text-xs text-blue-600">
                        {{ count($templates) }} template tersedia
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mb-4 sm:mb-6 flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ route('journal-entries.create') }}"
                class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border hover:shadow-md hover:scale-[1.02]"
                style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Jurnal Manual</span>
            </a>
            <a href="{{ route('journal-entries.index') }}"
                class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border hover:shadow-md hover:scale-[1.02]"
                style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Daftar Jurnal</span>
            </a>
        </div>

        <!-- Templates Grid -->
        <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
            @foreach ($templates as $template)
                <div class="group relative h-full">
                    <form action="{{ route('journal-entries.create-from-template') }}" method="GET" class="h-full">
                        <input type="hidden" name="template" value="{{ $template['id'] }}">

                        <button type="submit"
                            class="w-full h-full text-left rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg overflow-hidden bg-white group-hover:shadow-xl group-hover:border-blue-300 flex flex-col">

                            <!-- Card Header with Icon -->
                            <div class="p-3 sm:p-4 text-white flex-shrink-0"
                                style="background: linear-gradient(to right,
                                        @if ($template['color'] == 'from-green-500 to-green-600') #10b981, #059669
                                        @elseif($template['color'] == 'from-red-500 to-red-600')#ef4444, #dc2626
                                        @elseif($template['color'] == 'from-blue-500 to-blue-600')#3b82f6, #2563eb
                                        @elseif($template['color'] == 'from-orange-500 to-orange-600')#f97316, #ea580c
                                        @elseif($template['color'] == 'from-purple-500 to-purple-600')#a855f7, #9333ea
                                        @elseif($template['color'] == 'from-teal-500 to-teal-600')#14b8a6, #0d9488
                                        @elseif($template['color'] == 'from-indigo-500 to-indigo-600')#6366f1, #4f46e5
                                        @elseif($template['color'] == 'from-gray-500 to-gray-600')#6b7280, #4b5563
                                        @else #6b7280, #4b5563 @endif)">
                                <div class="flex items-center justify-between mb-2">
                                    <div
                                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-white bg-opacity-20 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $template['icon'] }}"></path>
                                        </svg>
                                    </div>
                                    <div class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded-full font-medium">
                                        Siap Pakai
                                    </div>
                                </div>

                                <h4 class="text-sm sm:text-base font-semibold mb-1 line-clamp-1">
                                    {{ $template['title'] }}</h4>
                                <p class="text-xs text-white text-opacity-90 line-clamp-2 leading-relaxed">
                                    {{ $template['description'] }}</p>
                            </div>

                            <!-- Card Body with Account Preview -->
                            <div class="p-3 sm:p-4 flex-grow flex flex-col">
                                <div class="space-y-2 flex-grow">
                                    <div class="text-xs font-medium text-gray-600 mb-2">Preview Akun:</div>
                                    @foreach ($template['accounts'] as $account)
                                        @if ($account['account_id'])
                                            <div
                                                class="flex items-center justify-between text-xs bg-gray-50 rounded-lg px-2 py-1.5">
                                                <span class="font-medium text-gray-700 truncate flex-1 mr-2">
                                                    {{ Str::limit($account['account_name'] ?? 'Belum diset', 18) }}
                                                </span>
                                                <span
                                                    class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 {{ $account['type'] === 'debet' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $account['type'] === 'debet' ? 'D' : 'K' }}
                                                </span>
                                            </div>
                                        @else
                                            <div
                                                class="flex items-center justify-between text-xs bg-yellow-50 rounded-lg px-2 py-1.5">
                                                <span class="font-medium text-yellow-700 truncate flex-1 mr-2">
                                                    Akun belum diset
                                                </span>
                                                <span
                                                    class="text-xs px-2 py-0.5 rounded-full font-medium flex-shrink-0 bg-yellow-100 text-yellow-800">
                                                    {{ $account['type'] === 'debet' ? 'D' : 'K' }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- Action Button -->
                                <div class="mt-3 pt-3 border-t border-gray-100 flex-shrink-0">
                                    <div
                                        class="flex items-center justify-center text-xs font-medium text-gray-600 group-hover:text-blue-600 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Gunakan Template
                                    </div>
                                </div>
                            </div>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Help Section -->
        <div class="mt-6 sm:mt-8 p-4 sm:p-6 rounded-xl border bg-gradient-to-br from-gray-50 to-gray-100"
            style="border-color: #E2E8F0;">
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 sm:gap-4">
                <div class="flex-shrink-0">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-base sm:text-lg font-semibold mb-3" style="color: #0F172A;">Cara Menggunakan
                        Jurnal Singkat</h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Langkah Penggunaan:</h5>
                            <ol class="list-decimal list-inside space-y-1 text-xs sm:text-sm text-gray-600">
                                <li>Pilih template sesuai jenis transaksi</li>
                                <li>Template mengisi akun debet/kredit otomatis</li>
                                <li>Isi tanggal, keterangan, dan nominal</li>
                                <li>Sistem memastikan jurnal balance</li>
                            </ol>
                        </div>
                        <div>
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Keterangan Simbol:</h5>
                            <div class="space-y-1.5">
                                <div class="flex items-center text-xs sm:text-sm">
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-100 text-green-800 font-bold mr-2 text-xs">D</span>
                                    <span class="text-gray-600">Debet - Penambahan aset/beban</span>
                                </div>
                                <div class="flex items-center text-xs sm:text-sm">
                                    <span
                                        class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-red-100 text-red-800 font-bold mr-2 text-xs">K</span>
                                    <span class="text-gray-600">Kredit - Penambahan liabilitas/pendapatan/modal</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Tips -->
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-xs sm:text-sm text-blue-700">
                            <span class="font-medium">💡 Tips:</span> Jika akun yang dibutuhkan belum tersedia, buat
                            terlebih dahulu di
                            <a href="{{ route('accounts.create') }}" class="underline hover:text-blue-800">Master
                                Data Akun</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Responsive grid utilities */
        @media (max-width: 475px) {
            .xs\:grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Line clamp utilities for better text truncation */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
            line-height: 1.4;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-height: 1.4;
        }

        /* Better touch targets on mobile */
        @media (max-width: 640px) {

            button,
            .button,
            a.button {
                min-height: 44px;
                touch-action: manipulation;
            }

            /* Improve card spacing on mobile */
            .grid {
                gap: 0.75rem;
            }
        }

        /* Enhanced hover effects */
        .group:hover .group-hover\:scale-\[1\.02\] {
            transform: scale(1.02);
        }

        .group:hover .group-hover\:shadow-xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .group:hover .group-hover\:border-blue-300 {
            border-color: #93c5fd;
        }

        .group:hover .group-hover\:text-blue-600 {
            color: #2563eb;
        }

        /* Better visual hierarchy */
        .leading-relaxed {
            line-height: 1.6;
        }

        /* Smooth transitions for all interactive elements */
        button,
        .button {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Ensure equal height cards */
        .h-full {
            height: 100%;
        }

        /* Better button focus states */
        button:focus,
        .button:focus {
            outline: 2px solid #14B8A6;
            outline-offset: 2px;
        }
    </style>
</x-admin-layout>
