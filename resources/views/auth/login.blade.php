<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 bg-gradient-to-br from-slate-50 to-slate-100">
        <div class="w-full max-w-sm sm:max-w-md">
            <!-- Main Card -->
            <div class="bg-white shadow-2xl rounded-2xl border border-slate-200 overflow-hidden">
                <!-- Header Section -->
                <div class="px-5 py-8 sm:px-6 sm:py-10">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl mb-4" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">Dompet Warung</h2>
                        <p class="text-sm text-slate-600 mb-1">Sistem Akuntansi Digital untuk UMKM</p>
                        <p class="text-xs text-slate-500">Kelola keuangan usaha Anda dengan mudah dan profesional</p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700 mb-2" />
                            <x-text-input id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan email Anda"
                                class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700 mb-2" />
                            <x-text-input id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password Anda"
                                class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between pt-1">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="rounded border-slate-300 shadow-sm"
                                    style="accent-color: #14B8A6;"
                                    name="remember">
                                <span class="ml-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-teal-600 hover:text-teal-800 underline focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 rounded transition-colors"
                                   href="{{ route('password.request') }}">
                                    {{ __('Lupa password?') }}
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="pt-3">
                            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-teal-500 to-cyan-400 hover:from-teal-600 hover:to-cyan-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02]">
                                {{ __('Masuk ke Dashboard') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Register Section -->
                <div class="px-5 py-5 bg-slate-50 border-t border-slate-200 sm:px-6">
                    <div class="text-center">
                        <p class="text-sm text-slate-600 mb-4">
                            Belum memiliki UMKM terdaftar?
                        </p>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center w-full px-4 py-2.5 bg-white border border-teal-500 rounded-xl font-semibold text-sm text-teal-600 hover:bg-teal-50 hover:border-teal-600 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Daftarkan UMKM Baru') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-8">
                <p class="text-xs text-slate-400">
                    © 2025 Dompet Warung. Sistem Akuntansi Digital untuk UMKM Indonesia. UPN Veteran Jawa Timur, KKN Tematik 2025 kelompok 25.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
