<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Dompet Warung') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="font-sans antialiased" style="background-color: #F8FAFC;">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">

        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto shadow-lg" style="background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%);">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 overflow-hidden" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <img src="{{ asset('images/logo.png') }}" alt="Dompet Warung Logo" class="w-8 h-8 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Dompet Warung</h1>
                        <p class="text-xs" style="color: #94A3B8;">Sistem Akuntansi</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-8 flex-1 px-2 space-y-1" x-data="{
                    openDropdowns: {
                        masterData: false,
                        transactions: false,
                        reports: false
                    },
                    toggleDropdown(key) {
                        this.openDropdowns[key] = !this.openDropdowns[key];
                    }
                }">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-300 hover:text-white hover:bg-slate-700' }}" {{ request()->routeIs('dashboard') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4m8-4v4"></path>
                        </svg>
                        Dashboard
                    </a>

                    <!-- Master Data Dropdown -->
                    <div class="mt-4">
                        <button @click="toggleDropdown('masterData')" class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-150">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                                Master Data
                            </div>
                            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openDropdowns.masterData }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openDropdowns.masterData" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-6 mt-2 space-y-1">
                            <a href="{{ route('accounts.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('accounts.*') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('accounts.*') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('accounts.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Kode Akun
                            </a>
                            <a href="{{ route('opening-balances.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('opening-balances.*') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('opening-balances.*') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('opening-balances.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Saldo Awal
                            </a>
                        </div>
                    </div>

                    <!-- Transaksi Dropdown -->
                    <div class="mt-2">
                        <button @click="toggleDropdown('transactions')" class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-150">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Transaksi
                            </div>
                            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openDropdowns.transactions }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openDropdowns.transactions" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-6 mt-2 space-y-1">
                            <a href="{{ route('journal-entries.quick-templates') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('journal-entries.quick-templates') ? 'style=background:linear-gradient(135deg,#3B82F6_0%,#1E40AF_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Jurnal Singkat
                            </a>
                            <a href="{{ route('journal-entries.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('journal-entries.*') && !request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('journal-entries.*') && !request()->routeIs('journal-entries.quick-templates') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('journal-entries.*') && !request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Jurnal Umum
                            </a>
                        </div>
                    </div>

                    <!-- Laporan Dropdown -->
                    <div class="mt-2">
                        <button @click="toggleDropdown('reports')" class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-150">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Laporan
                            </div>
                            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openDropdowns.reports }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="openDropdowns.reports" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-6 mt-2 space-y-1">
                            <a href="{{ route('reports.general-ledger') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('reports.general-ledger') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('reports.general-ledger') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('reports.general-ledger') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Buku Besar
                            </a>
                            <a href="{{ route('reports.income-statement') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('reports.income-statement') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('reports.income-statement') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('reports.income-statement') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Laba Rugi
                            </a>
                            <a href="{{ route('reports.balance-sheet') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('reports.balance-sheet') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('reports.balance-sheet') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                <svg class="mr-3 h-4 w-4 {{ request()->routeIs('reports.balance-sheet') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Neraca
                            </a>
                        </div>
                    </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 md:hidden" style="display: none;">
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50" @click="sidebarOpen = false" aria-hidden="true"></div>

            <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full shadow-lg" style="background: linear-gradient(180deg, #0F172A 0%, #1E293B 100%);">

                <!-- Mobile sidebar content -->
                <div class="flex flex-col flex-grow pt-5 pb-4 overflow-y-auto">
                    <!-- Header dengan Logo dan Close Button -->
                    <div class="flex items-center justify-between px-6 mb-8">
                        <!-- Logo Section -->
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 overflow-hidden" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                                <img src="{{ asset('images/logo.png') }}" alt="Dompet Warung Logo" class="w-8 h-8 object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-white">Dompet Warung</h1>
                                <p class="text-xs" style="color: #94A3B8;">Sistem Akuntansi</p>
                            </div>
                        </div>

                        <!-- Close Button -->
                        <button @click="sidebarOpen = false" type="button" class="flex items-center justify-center h-8 w-8 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white hover:bg-slate-700 transition-colors duration-150">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Mobile Navigation - Sama persis dengan Desktop -->
                    <nav class="mt-8 flex-1 px-2 space-y-1" x-data="{
                        mobileDropdowns: {
                            masterData: false,
                            transactions: false,
                            reports: false
                        },
                        toggleMobileDropdown(key) {
                            this.mobileDropdowns[key] = !this.mobileDropdowns[key];
                        }
                    }">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-300 hover:text-white hover:bg-slate-700' }}" {{ request()->routeIs('dashboard') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5v4m8-4v4"></path>
                            </svg>
                            Dashboard
                        </a>

                        <!-- Master Data Dropdown -->
                        <div class="mt-4">
                            <button @click="toggleMobileDropdown('masterData')" class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-150">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                    Master Data
                                </div>
                                <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': mobileDropdowns.masterData }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileDropdowns.masterData" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-6 mt-2 space-y-1">
                                <a href="{{ route('accounts.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('accounts.*') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('accounts.*') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('accounts.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Kode Akun
                                </a>
                                <a href="{{ route('opening-balances.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('opening-balances.*') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('opening-balances.*') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('opening-balances.*') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Saldo Awal
                                </a>
                            </div>
                        </div>

                        <!-- Transaksi Dropdown -->
                        <div class="mt-2">
                            <button @click="toggleMobileDropdown('transactions')" class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-150">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    Transaksi
                                </div>
                                <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': mobileDropdowns.transactions }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileDropdowns.transactions" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-6 mt-2 space-y-1">
                                <a href="{{ route('journal-entries.quick-templates') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('journal-entries.quick-templates') ? 'style=background:linear-gradient(135deg,#3B82F6_0%,#1E40AF_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Jurnal Singkat
                                </a>
                                <a href="{{ route('journal-entries.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('journal-entries.*') && !request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('journal-entries.*') && !request()->routeIs('journal-entries.quick-templates') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('journal-entries.*') && !request()->routeIs('journal-entries.quick-templates') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Jurnal Umum
                                </a>
                            </div>
                        </div>

                        <!-- Laporan Dropdown -->
                        <div class="mt-2">
                            <button @click="toggleMobileDropdown('reports')" class="group flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-300 hover:text-white hover:bg-slate-700 rounded-lg transition-colors duration-150">
                                <div class="flex items-center">
                                    <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Laporan
                                </div>
                                <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': mobileDropdowns.reports }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="mobileDropdowns.reports" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-6 mt-2 space-y-1">
                                <a href="{{ route('reports.general-ledger') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('reports.general-ledger') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('reports.general-ledger') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('reports.general-ledger') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Buku Besar
                                </a>
                                <a href="{{ route('reports.income-statement') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('reports.income-statement') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('reports.income-statement') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('reports.income-statement') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Laba Rugi
                                </a>
                                <a href="{{ route('reports.balance-sheet') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('reports.balance-sheet') ? 'text-white' : 'text-gray-400 hover:text-gray-300 hover:bg-slate-700' }}" {{ request()->routeIs('reports.balance-sheet') ? 'style=background:linear-gradient(135deg,#14B8A6_0%,#0F766E_100%);' : '' }}>
                                    <svg class="mr-3 h-4 w-4 {{ request()->routeIs('reports.balance-sheet') ? 'text-white' : 'text-gray-400 group-hover:text-gray-300' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Neraca
                                </a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <!-- Top header -->
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow border-b" style="border-color: #E2E8F0;">
                <button @click="sidebarOpen = true" type="button" class="px-4 border-r text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset md:hidden" style="border-color: #E2E8F0; --tw-ring-color: #14B8A6;">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

                <div class="flex-1 px-4 flex justify-between items-center">
                    <div class="flex-1">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h1 class="text-2xl font-semibold" style="color: #0F172A;">@yield('title', 'Dashboard')</h1>
                        @endisset
                    </div>

                    <div class="ml-4 flex items-center md:ml-6 space-x-4">
                        <!-- Notifications -->
                        <button class="bg-white p-1 rounded-full text-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2" style="--tw-ring-color: #14B8A6;" onmouseover="this.style.color='#334155'" onmouseout="this.style.color='#9CA3AF'">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5-5-5 5h5zm0 0v-5a6 6 0 00-6-6H7a6 6 0 00-6 6v5l5-5 5 5z" />
                            </svg>
                        </button>

                        <!-- Current Date -->
                        <div class="hidden sm:block text-right" id="datetime-display">
                            <p class="text-sm font-medium" style="color: #334155;" id="date-display">{{ now()->format('l, d F Y') }}</p>
                            <p class="text-xs" style="color: #64748B;" id="time-display">{{ now()->format('H:i') }} WIB</p>
                        </div>

                        <!-- User Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center space-x-3 text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2" style="--tw-ring-color: #14B8A6;">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium" style="color: #0F172A;">{{ Auth::user()->name }}</p>
                                    <p class="text-xs" style="color: #64748B;">Administrator</p>
                                </div>
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                <div class="py-1">
                                    <div class="px-4 py-3 border-b" style="border-color: #E2E8F0;">
                                        <p class="text-sm font-medium" style="color: #0F172A;">{{ Auth::user()->name }}</p>
                                        <p class="text-xs" style="color: #64748B;">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <div class="border-t" style="border-color: #E2E8F0;">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                <svg class="mr-3 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <main class="flex-1 relative overflow-y-auto focus:outline-none">
                <div class="py-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <script>
        // Function to update date and time
        function updateDateTime() {
            const now = new Date();

            // Array untuk nama hari dalam bahasa Indonesia
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

            // Array untuk nama bulan dalam bahasa Indonesia
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            // Format tanggal: Senin, 03 Juli 2025
            const dayName = days[now.getDay()];
            const date = now.getDate().toString().padStart(2, '0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName}, ${date} ${month} ${year}`;

            // Format waktu: 14:30 WIB
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes} WIB`;

            // Update elemen di DOM
            const dateDisplay = document.getElementById('date-display');
            const timeDisplay = document.getElementById('time-display');

            if (dateDisplay) {
                dateDisplay.textContent = dateString;
            }
            if (timeDisplay) {
                timeDisplay.textContent = timeString;
            }
        }

        // Update waktu setiap detik
        setInterval(updateDateTime, 1000);

        // Update waktu saat halaman dimuat
        document.addEventListener('DOMContentLoaded', updateDateTime);
    </script>
</body>
</html>
