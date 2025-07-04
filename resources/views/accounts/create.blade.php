@section('title', 'Tambah Akun')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Tambah Akun</h1>
            <a href="{{ route('accounts.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Form Akun Baru</h2>
            </div>

            <form action="{{ route('accounts.store') }}" method="POST" class="px-6 py-4">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="kode_akun" class="block text-sm font-medium text-gray-700">Kode Akun</label>
                        <input type="text" id="kode_akun" name="kode_akun" value="{{ old('kode_akun') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('kode_akun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nama_akun" class="block text-sm font-medium text-gray-700">Nama Akun</label>
                        <input type="text" id="nama_akun" name="nama_akun" value="{{ old('nama_akun') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                        @error('nama_akun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tipe_akun" class="block text-sm font-medium text-gray-700">Tipe Akun</label>
                        <select id="tipe_akun" name="tipe_akun" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih Tipe Akun</option>
                            <option value="aset" {{ old('tipe_akun') == 'aset' ? 'selected' : '' }}>Aset</option>
                            <option value="kewajiban" {{ old('tipe_akun') == 'kewajiban' ? 'selected' : '' }}>Kewajiban</option>
                            <option value="modal" {{ old('tipe_akun') == 'modal' ? 'selected' : '' }}>Modal</option>
                            <option value="pendapatan" {{ old('tipe_akun') == 'pendapatan' ? 'selected' : '' }}>Pendapatan</option>
                            <option value="beban" {{ old('tipe_akun') == 'beban' ? 'selected' : '' }}>Beban</option>
                        </select>
                        @error('tipe_akun')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="saldo_normal" class="block text-sm font-medium text-gray-700">Saldo Normal</label>
                        <select id="saldo_normal" name="saldo_normal" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih Saldo Normal</option>
                            <option value="debit" {{ old('saldo_normal') == 'debit' ? 'selected' : '' }}>Debit</option>
                            <option value="kredit" {{ old('saldo_normal') == 'kredit' ? 'selected' : '' }}>Kredit</option>
                        </select>
                        @error('saldo_normal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm font-medium text-gray-700">Aktif</label>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('accounts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg font-medium">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
