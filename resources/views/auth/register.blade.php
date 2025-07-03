<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 bg-gradient-to-br from-slate-50 to-slate-100">
        <div class="w-full max-w-sm sm:max-w-md lg:max-w-4xl xl:max-w-5xl">
            <!-- Main Card -->
            <div class="bg-white shadow-2xl rounded-2xl border border-slate-200 overflow-hidden">
                <!-- Header Section -->
                <div class="px-5 py-8 sm:px-6 sm:py-10 lg:px-8 xl:px-10">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl mb-4" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">Daftarkan UMKM Anda</h2>
                        <p class="text-sm text-slate-600">Mulai kelola keuangan usaha dengan mudah</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- 2 Column Layout for Tablet & Desktop, Single Column for Mobile -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 lg:gap-10">

                            <!-- Left Column - Data Pemilik -->
                            <div class="space-y-5">
                                <!-- Data Pemilik Section -->
                                <div class="bg-slate-50 rounded-lg p-4">
                                    <h3 class="text-base font-semibold text-slate-900 mb-1">Data Pemilik</h3>
                                    <p class="text-sm text-slate-600">Informasi pemilik UMKM</p>
                                </div>

                                <!-- Name -->
                                <div>
                                    <x-input-label for="name" :value="__('Nama Lengkap Pemilik')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="name" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="email" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="password" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm"
                                                    type="password"
                                                    name="password"
                                                    required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="password_confirmation" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm"
                                                    type="password"
                                                    name="password_confirmation" required autocomplete="new-password" />
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Right Column - Data UMKM -->
                            <div class="space-y-5">
                                <!-- Data UMKM Section -->
                                <div class="bg-slate-50 rounded-lg p-4">
                                    <h3 class="text-base font-semibold text-slate-900 mb-1">Data UMKM</h3>
                                    <p class="text-sm text-slate-600">Informasi usaha Anda</p>
                                </div>

                                <!-- Nama UMKM -->
                                <div>
                                    <x-input-label for="nama_umkm" :value="__('Nama UMKM/Usaha')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="nama_umkm" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" type="text" name="nama_umkm" :value="old('nama_umkm')" required />
                                    <x-input-error :messages="$errors->get('nama_umkm')" class="mt-2" />
                                </div>

                                <!-- Nama Pemilik -->
                                <div>
                                    <x-input-label for="nama_pemilik" :value="__('Nama Pemilik/Penanggung Jawab')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="nama_pemilik" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" type="text" name="nama_pemilik" :value="old('nama_pemilik')" required />
                                    <x-input-error :messages="$errors->get('nama_pemilik')" class="mt-2" />
                                </div>

                                <!-- Jenis Usaha -->
                                <div>
                                    <x-input-label for="jenis_usaha" :value="__('Jenis Usaha')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <select id="jenis_usaha" name="jenis_usaha" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 text-sm">
                                        <option value="">Pilih Jenis Usaha</option>
                                        <option value="Warung/Toko Kelontong" {{ old('jenis_usaha') == 'Warung/Toko Kelontong' ? 'selected' : '' }}>Warung/Toko Kelontong</option>
                                        <option value="Rumah Makan/Kuliner" {{ old('jenis_usaha') == 'Rumah Makan/Kuliner' ? 'selected' : '' }}>Rumah Makan/Kuliner</option>
                                        <option value="Fashion/Pakaian" {{ old('jenis_usaha') == 'Fashion/Pakaian' ? 'selected' : '' }}>Fashion/Pakaian</option>
                                        <option value="Elektronik" {{ old('jenis_usaha') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                        <option value="Jasa" {{ old('jenis_usaha') == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                                        <option value="Lainnya" {{ old('jenis_usaha') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('jenis_usaha')" class="mt-2" />
                                </div>

                                <!-- Telepon -->
                                <div>
                                    <x-input-label for="telepon" :value="__('No. Telepon/WhatsApp')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <x-text-input id="telepon" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 transition-colors duration-200 text-sm" type="tel" name="telepon" :value="old('telepon')" />
                                    <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                                </div>

                                <!-- Alamat -->
                                <div>
                                    <x-input-label for="alamat" :value="__('Alamat Usaha')" class="text-sm font-medium text-slate-700 mb-2" />
                                    <textarea id="alamat" name="alamat" rows="3" class="w-full px-3 py-2.5 rounded-lg border border-slate-300 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-500 focus:ring-opacity-50 text-sm">{{ old('alamat') }}</textarea>
                                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-gradient-to-r from-teal-500 to-cyan-400 hover:from-teal-600 hover:to-cyan-500 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02]">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('Daftarkan UMKM Saya') }}
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center mt-6">
                            <p class="text-sm text-slate-600">
                                Sudah memiliki akun UMKM?
                            </p>
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center w-full mt-3 px-4 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold text-sm text-slate-600 hover:bg-slate-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                {{ __('Masuk ke Akun Saya') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
