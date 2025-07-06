<x-admin-layout>
    <x-slot name="title">Daftar Akun</x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">📊 Daftar Akun</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="truncate">Chart of Accounts - Bagan Akun</span>
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

    @if($errors->any())
        <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <div class="text-xs sm:text-sm font-medium text-red-800">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons Section -->
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 action-buttons-mobile">
            <a href="{{ route('accounts.create') }}"
               class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02] hover-lift smooth-transition transform"
               style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Akun
            </a>
            <a href="{{ route('accounts.export', request()->query()) }}"
               class="inline-flex items-center px-4 py-2 border border-green-300 rounded-lg text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 hover:shadow-md hover-lift smooth-transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </a>
        </div>
        <div class="flex items-center text-sm text-gray-600">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Total: {{ $accounts->total() }} akun
        </div>
    </div>

    <!-- Filter Toggle Button -->
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
            @if(request()->hasAny(['search', 'kode_akun', 'nama_akun', 'tipe_akun', 'kategori', 'is_active']))
                <span class="text-xs font-medium text-gray-500">Filter aktif:</span>

                @if(request('search'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                        🔍 {{ Str::limit(request('search'), 15) }}
                    </span>
                @endif

                @if(request('kode_akun'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                        Kode: {{ request('kode_akun') }}
                    </span>
                @endif

                @if(request('nama_akun'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                        Nama: {{ Str::limit(request('nama_akun'), 15) }}
                    </span>
                @endif

                @if(request('tipe_akun'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">
                        {{ ucfirst(request('tipe_akun')) }}
                    </span>
                @endif

                @if(request('kategori'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-cyan-100 text-cyan-800">
                        {{ ucfirst(str_replace('_', ' ', request('kategori'))) }}
                    </span>
                @endif

                @if(request('is_active'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                        {{ request('is_active') == '1' ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                @endif
            @endif
        </div>
    </div>

    <!-- Filter Section -->
    <div id="filterSection" class="mb-4 sm:mb-6 bg-white rounded-xl shadow-lg border p-4 sm:p-6 hidden" style="border-color: #E2E8F0;">
        <form method="GET" action="{{ route('accounts.index') }}" class="space-y-4" id="filterForm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Filter & Pencarian</h3>
                </div>

                <!-- Reset & Apply Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('accounts.index') }}"
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <!-- Pencarian Umum -->
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: #374151;">Pencarian Umum</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari kode, nama, atau deskripsi..."
                           class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                </div>

                <!-- Filter Kode Akun -->
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: #374151;">Kode Akun</label>
                    <input type="text"
                           name="kode_akun"
                           value="{{ request('kode_akun') }}"
                           placeholder="Cari berdasarkan kode akun..."
                           class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                </div>

                <!-- Filter Nama Akun -->
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: #374151;">Nama Akun</label>
                    <input type="text"
                           name="nama_akun"
                           value="{{ request('nama_akun') }}"
                           placeholder="Cari berdasarkan nama akun..."
                           class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                </div>

                <!-- Filter Tipe Akun -->
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: #374151;">Tipe Akun</label>
                    <select name="tipe_akun"
                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                        <option value="">Semua Tipe</option>
                        <option value="aset" {{ request('tipe_akun') == 'aset' ? 'selected' : '' }}>💰 Aset</option>
                        <option value="liabilitas" {{ request('tipe_akun') == 'liabilitas' ? 'selected' : '' }}>💳 Liabilitas</option>
                        <option value="ekuitas" {{ request('tipe_akun') == 'ekuitas' ? 'selected' : '' }}>📊 Ekuitas</option>
                        <option value="pendapatan" {{ request('tipe_akun') == 'pendapatan' ? 'selected' : '' }}>📈 Pendapatan</option>
                        <option value="beban" {{ request('tipe_akun') == 'beban' ? 'selected' : '' }}>📉 Beban</option>
                    </select>
                </div>

                <!-- Filter Kategori -->
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: #374151;">Kategori</label>
                    <select name="kategori"
                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                        <option value="">Semua Kategori</option>
                        <option value="lancar" {{ request('kategori') == 'lancar' ? 'selected' : '' }}>Lancar</option>
                        <option value="tidak_lancar" {{ request('kategori') == 'tidak_lancar' ? 'selected' : '' }}>Tidak Lancar</option>
                        <option value="operasional" {{ request('kategori') == 'operasional' ? 'selected' : '' }}>Operasional</option>
                        <option value="non_operasional" {{ request('kategori') == 'non_operasional' ? 'selected' : '' }}>Non Operasional</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div>
                    <label class="block text-xs font-medium mb-1" style="color: #374151;">Status</label>
                    <select name="is_active"
                            class="w-full px-3 py-2 text-xs border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>❌ Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Active Filters Display -->
        @if(request()->hasAny(['search', 'kode_akun', 'nama_akun', 'tipe_akun', 'kategori', 'is_active']))
            <div class="flex flex-wrap gap-2 pt-3 border-t border-gray-200">
                <span class="text-xs font-medium text-gray-500">Filter Aktif:</span>

                @if(request('search'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                        🔍 {{ Str::limit(request('search'), 20) }}
                        <button type="button" onclick="clearFilter('search')" class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                    </span>
                @endif

                @if(request('kode_akun'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">
                        Kode: {{ request('kode_akun') }}
                        <button type="button" onclick="clearFilter('kode_akun')" class="ml-1 text-green-600 hover:text-green-800">×</button>
                    </span>
                @endif

                @if(request('nama_akun'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-800">
                        Nama: {{ Str::limit(request('nama_akun'), 20) }}
                        <button type="button" onclick="clearFilter('nama_akun')" class="ml-1 text-purple-600 hover:text-purple-800">×</button>
                    </span>
                @endif

                @if(request('tipe_akun'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">
                        Tipe: {{ ucfirst(request('tipe_akun')) }}
                        <button type="button" onclick="clearFilter('tipe_akun')" class="ml-1 text-orange-600 hover:text-orange-800">×</button>
                    </span>
                @endif

                @if(request('kategori'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-cyan-100 text-cyan-800">
                        Kategori: {{ ucfirst(str_replace('_', ' ', request('kategori'))) }}
                        <button type="button" onclick="clearFilter('kategori')" class="ml-1 text-cyan-600 hover:text-cyan-800">×</button>
                    </span>
                @endif

                @if(request('is_active'))
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-yellow-100 text-yellow-800">
                        Status: {{ request('is_active') == '1' ? 'Aktif' : 'Tidak Aktif' }}
                        <button type="button" onclick="clearFilter('is_active')" class="ml-1 text-yellow-600 hover:text-yellow-800">×</button>
                    </span>
                @endif
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" style="border: 1px solid #E2E8F0;">
        <div class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-sm sm:text-base font-semibold text-gray-900">
                    Data Akun ({{ $accounts->total() }} total)
                </h3>
                <span class="text-xs text-gray-500">
                    Halaman {{ $accounts->currentPage() }} dari {{ $accounts->lastPage() }}
                </span>
            </div>
        </div>
        @if($accounts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Akun</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Akun</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($accounts as $account)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $account->kode_akun }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $account->nama_akun }}</div>
                                @if($account->parent_id)
                                    <div class="text-xs text-gray-500">Parent: {{ $account->parent_id }}</div>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeColors = [
                                        'aset' => 'bg-blue-100 text-blue-800',
                                        'liabilitas' => 'bg-red-100 text-red-800',
                                        'ekuitas' => 'bg-green-100 text-green-800',
                                        'pendapatan' => 'bg-cyan-100 text-cyan-800',
                                        'beban' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $typeIcons = [
                                        'aset' => '💰',
                                        'liabilitas' => '💳',
                                        'ekuitas' => '📊',
                                        'pendapatan' => '📈',
                                        'beban' => '📉'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $typeColors[$account->tipe_akun] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $typeIcons[$account->tipe_akun] ?? '❓' }}
                                    {{ ucfirst($account->tipe_akun) }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($account->kategori)
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst(str_replace('_', ' ', $account->kategori)) }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                @if($account->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✅ Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        ❌ Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4">
                                @if($account->deskripsi)
                                    <div class="text-sm text-gray-900 truncate max-w-xs" title="{{ $account->deskripsi }}">
                                        {{ $account->deskripsi }}
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('accounts.show', $account) }}"
                                       class="text-teal-600 hover:text-teal-900 transition-colors duration-200"
                                       title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('accounts.edit', $account) }}"
                                       class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                       title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <button type="button"
                                            onclick="confirmDelete('{{ $account->id }}', '{{ $account->nama_akun }}')"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($accounts->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($accounts->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                            Previous
                        </span>
                    @else
                        <a href="{{ $accounts->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            Previous
                        </a>
                    @endif

                    @if($accounts->hasMorePages())
                        <a href="{{ $accounts->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            Next
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                            Next
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Menampilkan
                            <span class="font-medium">{{ $accounts->firstItem() }}</span>
                            s/d
                            <span class="font-medium">{{ $accounts->lastItem() }}</span>
                            dari
                            <span class="font-medium">{{ $accounts->total() }}</span>
                            data
                        </p>
                    </div>
                    <div>
                        {{ $accounts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data akun ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($activeFilters > 0)
                        Coba ubah filter pencarian atau
                        <a href="{{ route('accounts.index') }}" class="text-teal-600 hover:text-teal-500">hapus semua filter</a>
                    @else
                        Mulai dengan membuat akun pertama untuk chart of accounts Anda
                    @endif
                </p>
                @if($activeFilters == 0)
                <div class="mt-6">
                    <a href="{{ route('accounts.create') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Akun Pertama
                    </a>
                </div>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Konfirmasi Hapus</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus akun <strong id="account-name"></strong>?
                </p>
                <p class="text-xs text-red-600 mt-2">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Aksi ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <div class="flex space-x-2">
                    <button id="cancelDelete"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                    <form method="POST" id="delete-form" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
        localStorage.setItem('accountsFilterSectionVisible', 'true');
    } else {
        // Hide filter section
        filterSection.style.animation = 'slideUp 0.3s ease-out';
        setTimeout(() => {
            filterSection.classList.add('hidden');
        }, 250);
        filterText.textContent = 'Tampilkan Filter';
        chevronIcon.style.transform = 'rotate(0deg)';

        // Show active filters summary if any filters are active
        @if(request()->hasAny(['search', 'kode_akun', 'nama_akun', 'tipe_akun', 'kategori', 'is_active']))
            activeFiltersSummary.classList.remove('hidden');
        @endif

        toggleButton.style.background = 'white';
        toggleButton.style.color = '#64748B';
        toggleButton.style.borderColor = '#E2E8F0';

        // Store state in localStorage
        localStorage.setItem('accountsFilterSectionVisible', 'false');
    }
}

// Initialize page on load
document.addEventListener('DOMContentLoaded', function() {
    const filterSection = document.getElementById('filterSection');
    const filterText = document.getElementById('filterText');
    const chevronIcon = document.getElementById('chevronIcon');
    const activeFiltersSummary = document.getElementById('activeFiltersSummary');
    const toggleButton = document.getElementById('toggleFilter');

    // Check if there are active filters
    const hasActiveFilters = {{ request()->hasAny(['search', 'kode_akun', 'nama_akun', 'tipe_akun', 'kategori', 'is_active']) ? 'true' : 'false' }};

    // Get saved state from localStorage, default to showing if there are active filters
    const savedState = localStorage.getItem('accountsFilterSectionVisible');
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

    // Auto submit on select change
    const filterSelects = document.querySelectorAll('#filterForm select[name]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            const form = document.getElementById('filterForm');
            if (form) {
                form.submit();
            }
        });
    });

    // Real-time search with debounce
    const searchInputs = document.querySelectorAll('#filterForm input[type="text"][name]');
    let searchTimeout;

    searchInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    const form = document.getElementById('filterForm');
                    if (form) {
                        form.submit();
                    }
                }
            }, 800);
        });
    });

    // Enter key submit for search inputs
    searchInputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const form = document.getElementById('filterForm');
                if (form) {
                    form.submit();
                }
            }
        });
    });

    // Smooth animations for table rows
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 50);
    });

    // Add loading state to form submissions
    const filterForm = document.getElementById('filterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<svg class="animate-spin w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mencari...';
                submitBtn.disabled = true;
            }
        });
    }
});

// Clear individual filter functions
function clearFilter(filterName) {
    const input = document.querySelector(`input[name="${filterName}"], select[name="${filterName}"]`);
    if (input) {
        input.value = '';
        input.form.submit();
    }
}

// Delete confirmation function (global)
function confirmDelete(accountId, accountName) {
    const accountNameEl = document.getElementById('account-name');
    const deleteForm = document.getElementById('delete-form');
    const deleteModal = document.getElementById('deleteModal');

    if (accountNameEl && deleteForm && deleteModal) {
        accountNameEl.textContent = accountName;
        deleteForm.action = `/accounts/${accountId}`;
        deleteModal.classList.remove('hidden');
    }
}

// Cancel delete handler
document.addEventListener('DOMContentLoaded', function() {
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const deleteModal = document.getElementById('deleteModal');

    if (cancelDeleteBtn && deleteModal) {
        cancelDeleteBtn.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });
    }

    // Close modal when clicking outside
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + F to toggle filter
    if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
        e.preventDefault();
        if (typeof toggleFilterSection === 'function') {
            toggleFilterSection();
        }
    }

    // Escape to close filter and modals
    if (e.key === 'Escape') {
        const filterSection = document.getElementById('filterSection');
        if (filterSection && !filterSection.classList.contains('hidden')) {
            if (typeof toggleFilterSection === 'function') {
                toggleFilterSection();
            }
        }

        // Also close delete modal if open
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal && !deleteModal.classList.contains('hidden')) {
            deleteModal.classList.add('hidden');
        }
    }
});
</script>

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

/* Ensure better touch compatibility */
#toggleFilter {
    -webkit-tap-highlight-color: transparent;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    min-height: 44px; /* Minimum touch target size */
    min-width: 44px;
}

/* Active state for better feedback */
#toggleFilter:active {
    transform: translateY(1px);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Focus states for accessibility */
#toggleFilter:focus-visible {
    outline: 2px solid #14B8A6;
    outline-offset: 2px;
}

/* Mobile responsiveness */
@media (max-width: 640px) {
    #toggleFilter {
        padding: 12px 16px;
        font-size: 14px;
    }

    .action-buttons-mobile {
        flex-direction: column;
        align-items: stretch;
    }

    .action-buttons-mobile a {
        text-align: center;
        justify-content: center;
    }
}

/* Smooth transitions for all interactive elements */
.smooth-transition {
    transition: all 0.2s ease-in-out;
}

/* Better hover states */
.hover-lift:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Loading state for filter */
.filter-loading {
    opacity: 0.7;
    pointer-events: none;
}

.filter-loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #14B8A6;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
</x-admin-layout>
