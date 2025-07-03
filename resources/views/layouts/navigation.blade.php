<nav x-data="{ open: false }" class="mobile-navbar">
    <!-- Primary Navigation Menu -->
    <div class="mobile-container">
        <div class="mobile-flex-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <div class="mobile-navbar-logo">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <span class="text-sm sm:text-base lg:text-lg font-bold text-slate-800 truncate">Dompet Warung</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 lg:space-x-8 sm:-my-px sm:ms-6 lg:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="mobile-nav-link">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')" class="mobile-nav-link">
                        {{ __('Kode Akun') }}
                    </x-nav-link>
                    <x-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')" class="mobile-nav-link">
                        {{ __('Jurnal Umum') }}
                    </x-nav-link>
                    <x-nav-link :href="route('opening-balances.index')" :active="request()->routeIs('opening-balances.*')" class="mobile-nav-link">
                        {{ __('Saldo Awal') }}
                    </x-nav-link>

                    <!-- Reports Dropdown -->
                    <x-dropdown align="left" width="48">
                        <x-slot name="trigger">
                            <button class="mobile-nav-dropdown">
                                <div>{{ __('Laporan') }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('reports.general-ledger')">
                                {{ __('Buku Besar') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.trial-balance')">
                                {{ __('Neraca Saldo') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.worksheet')">
                                {{ __('Neraca Lajur') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.income-statement')">
                                {{ __('Laba Rugi') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('reports.balance-sheet')">
                                {{ __('Laporan Posisi Keuangan') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="mobile-user-dropdown">
                            <div class="truncate max-w-32 lg:max-w-none">{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="mobile-hamburger">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden mobile-mobile-menu">
        <!-- Mobile Menu Header -->
        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-gradient-to-br from-teal-500 to-teal-600 rounded-md flex items-center justify-center mr-2">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <span class="text-base font-semibold text-slate-800">Menu</span>
            </div>
            <button @click="open = false" class="p-2 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-colors duration-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('accounts.index')" :active="request()->routeIs('accounts.*')">
                {{ __('Kode Akun') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('transactions.index')" :active="request()->routeIs('transactions.*')">
                {{ __('Jurnal Umum') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('opening-balances.index')" :active="request()->routeIs('opening-balances.*')">
                {{ __('Saldo Awal') }}
            </x-responsive-nav-link>

            <!-- Mobile Reports Menu -->
            <div class="px-4 py-2">
                <div class="font-medium text-sm text-slate-600 uppercase tracking-wider">{{ __('Laporan') }}</div>
                <div class="mt-2 space-y-1">
                    <x-responsive-nav-link :href="route('reports.general-ledger')">
                        {{ __('Buku Besar') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.trial-balance')">
                        {{ __('Neraca Saldo') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.worksheet')">
                        {{ __('Neraca Lajur') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.income-statement')">
                        {{ __('Laba Rugi') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('reports.balance-sheet')">
                        {{ __('Laporan Posisi Keuangan') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4">
                <div class="font-medium text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
