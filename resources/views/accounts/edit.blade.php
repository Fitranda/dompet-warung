<x-admin-layout>
    <x-slot name="title">Edit Akun</x-slot>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">✏️ Edit Akun</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="truncate">Ubah data akun: <strong>{{ $account->nama_akun }}</strong></span>
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('accounts.index') }}"
                   class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
        <!-- Success/Error Messages -->
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
                            <p class="font-semibold">Terdapat kesalahan:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Info Usage (if any) -->
        @if(method_exists($account, 'journalDetails') && $account->journalDetails()->exists())
            <div class="mb-4 sm:mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-3 sm:p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-2 sm:ml-3">
                        <div class="text-xs sm:text-sm font-medium text-yellow-800">
                            <p class="font-semibold">Perhatian:</p>
                            <p>Akun ini sudah digunakan dalam {{ $account->journalDetails()->count() }} transaksi jurnal. Perubahan pada akun ini dapat mempengaruhi laporan keuangan.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-lg border overflow-hidden" style="border-color: #E2E8F0;">
            <!-- Card Header -->
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%);">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Form Edit Akun</h3>
                </div>
            </div>

            <!-- Card Body -->
            <div class="p-4 sm:p-6">
                <form action="{{ route('accounts.update', $account) }}" method="POST" id="accountForm" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <!-- Kode Akun -->
                        <div>
                            <label for="kode_akun" class="block text-sm font-medium mb-2" style="color: #374151;">
                                Kode Akun <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('kode_akun') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   id="kode_akun"
                                   name="kode_akun"
                                   value="{{ old('kode_akun', $account->kode_akun) }}"
                                   placeholder="Contoh: 1-101"
                                   required>
                            @error('kode_akun')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Masukkan kode unik untuk akun ini</p>
                        </div>

                        <!-- Nama Akun -->
                        <div>
                            <label for="nama_akun" class="block text-sm font-medium mb-2" style="color: #374151;">
                                Nama Akun <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('nama_akun') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   id="nama_akun"
                                   name="nama_akun"
                                   value="{{ old('nama_akun', $account->nama_akun) }}"
                                   placeholder="Contoh: Kas"
                                   required>
                            @error('nama_akun')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Akun -->
                        <div>
                            <label for="tipe_akun" class="block text-sm font-medium mb-2" style="color: #374151;">
                                Tipe Akun <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('tipe_akun') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="tipe_akun"
                                    name="tipe_akun"
                                    required>
                                <option value="">Pilih Tipe Akun</option>
                                <option value="aset" {{ old('tipe_akun', $account->tipe_akun) == 'aset' ? 'selected' : '' }}>💰 Aset</option>
                                <option value="liabilitas" {{ old('tipe_akun', $account->tipe_akun) == 'liabilitas' ? 'selected' : '' }}>💳 Liabilitas</option>
                                <option value="ekuitas" {{ old('tipe_akun', $account->tipe_akun) == 'ekuitas' ? 'selected' : '' }}>📊 Ekuitas</option>
                                <option value="pendapatan" {{ old('tipe_akun', $account->tipe_akun) == 'pendapatan' ? 'selected' : '' }}>📈 Pendapatan</option>
                                <option value="beban" {{ old('tipe_akun', $account->tipe_akun) == 'beban' ? 'selected' : '' }}>📉 Beban</option>
                            </select>
                            @error('tipe_akun')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium mb-2" style="color: #374151;">
                                Kategori
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('kategori') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="kategori"
                                    name="kategori">
                                <option value="">Pilih Kategori (Opsional)</option>
                                <option value="lancar" {{ old('kategori', $account->kategori) == 'lancar' ? 'selected' : '' }}>Lancar</option>
                                <option value="tidak_lancar" {{ old('kategori', $account->kategori) == 'tidak_lancar' ? 'selected' : '' }}>Tidak Lancar</option>
                                <option value="operasional" {{ old('kategori', $account->kategori) == 'operasional' ? 'selected' : '' }}>Operasional</option>
                                <option value="non_operasional" {{ old('kategori', $account->kategori) == 'non_operasional' ? 'selected' : '' }}>Non Operasional</option>
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Parent ID -->
                        <div>
                            <label for="parent_id" class="block text-sm font-medium mb-2" style="color: #374151;">
                                Parent Account
                            </label>
                            <input type="text"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('parent_id') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                   id="parent_id"
                                   name="parent_id"
                                   value="{{ old('parent_id', $account->parent_id) }}"
                                   placeholder="Kode akun induk (opsional)">
                            @error('parent_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Kode akun induk jika ini adalah sub-akun</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium mb-2" style="color: #374151;">
                                Status
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('is_active') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                    id="is_active"
                                    name="is_active">
                                <option value="1" {{ old('is_active', $account->is_active) == '1' ? 'selected' : '' }}>✅ Aktif</option>
                                <option value="0" {{ old('is_active', $account->is_active) == '0' ? 'selected' : '' }}>❌ Tidak Aktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi - Full Width -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium mb-2" style="color: #374151;">
                            Deskripsi
                        </label>
                        <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors duration-200 @error('deskripsi') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                  id="deskripsi"
                                  name="deskripsi"
                                  rows="3"
                                  placeholder="Deskripsi lengkap tentang akun ini (opsional)">{{ old('deskripsi', $account->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                        <div class="flex-1"></div>
                        <div class="flex gap-2">
                            <a href="{{ route('accounts.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:shadow-lg hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                                    style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);"
                                    id="submitBtn">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Akun
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('accountForm');
        const submitBtn = document.getElementById('submitBtn');

        // Auto format kode akun
        const kodeAkunInput = document.getElementById('kode_akun');
        kodeAkunInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            e.target.value = value;
        });

        // Form submission with loading state
        form.addEventListener('submit', function(e) {
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Memperbarui...
            `;
            submitBtn.disabled = true;
        });

        // Auto capitalize nama akun
        const namaAkunInput = document.getElementById('nama_akun');
        namaAkunInput.addEventListener('blur', function(e) {
            let value = e.target.value.trim();
            if (value) {
                e.target.value = value.charAt(0).toUpperCase() + value.slice(1);
            }
        });

        // Real-time validation feedback
        const requiredInputs = document.querySelectorAll('input[required], select[required]');
        requiredInputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                }
            });

            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                }
            });
        });

        // Auto-hide success messages after 5 seconds
        const successMessage = document.querySelector('.bg-green-50');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.transition = 'opacity 0.5s ease-out';
                successMessage.style.opacity = '0';
                setTimeout(() => {
                    successMessage.remove();
                }, 500);
            }, 5000);
        }
    });
    </script>
    @endpush
</x-admin-layout>
