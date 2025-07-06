@section('title', 'Detail Jurnal Umum')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold" style="color: #0F172A;">Detail Jurnal Umum</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm md:text-base" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat detail transaksi jurnal umum
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('journal-entries.edit', $journalEntry) }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all duration-200 transform hover:scale-105"
                   style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('journal-entries.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 border"
                   style="color: #64748B; border-color: #E2E8F0; background: white;">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-lg border overflow-hidden" style="border-color: #E2E8F0;">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold" style="color: #0F172A;">{{ $journalEntry->no_jurnal }}</h3>
                            <p class="text-sm" style="color: #64748B;">{{ $journalEntry->tanggal->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm" style="color: #64748B;">Dibuat oleh</div>
                        <div class="text-sm font-medium" style="color: #0F172A;">{{ $journalEntry->user->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Journal Information -->
            <div class="p-6 space-y-6">
                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: #374151;">No. Jurnal</label>
                        <div class="px-3 py-2.5 rounded-lg border bg-gray-50 text-sm" style="border-color: #D1D5DB; color: #6B7280;">
                            {{ $journalEntry->no_jurnal }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: #374151;">Tanggal</label>
                        <div class="px-3 py-2.5 rounded-lg border bg-gray-50 text-sm" style="border-color: #D1D5DB; color: #6B7280;">
                            {{ $journalEntry->tanggal->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: #374151;">Keterangan</label>
                    <div class="px-3 py-2.5 rounded-lg border bg-gray-50 text-sm" style="border-color: #D1D5DB; color: #6B7280;">
                        {{ $journalEntry->keterangan }}
                    </div>
                </div>

                <!-- Journal Details -->
                <div>
                    <label class="block text-sm font-medium mb-4" style="color: #374151;">Detail Jurnal</label>
                    <div class="border rounded-lg overflow-hidden" style="border-color: #E2E8F0;">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y" style="divide-color: #E2E8F0;">
                                <thead style="background: #F8FAFC;">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Kode Akun</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Nama Akun</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Debit</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y" style="divide-color: #E2E8F0;">
                                    @foreach($journalEntry->details as $detail)
                                        <tr class="hover:bg-slate-50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="text-sm font-medium" style="color: #0F172A;">{{ $detail->account->kode_akun }}</div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="text-sm" style="color: #334155;">{{ $detail->account->nama_akun }}</div>
                                                <div class="text-xs" style="color: #64748B;">{{ ucfirst($detail->account->tipe_akun) }}</div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                                @if($detail->debit > 0)
                                                    <div class="text-sm font-medium" style="color: #059669;">Rp {{ number_format($detail->debit, 0, ',', '.') }}</div>
                                                @else
                                                    <div class="text-sm" style="color: #94A3B8;">-</div>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                                @if($detail->kredit > 0)
                                                    <div class="text-sm font-medium" style="color: #DC2626;">Rp {{ number_format($detail->kredit, 0, ',', '.') }}</div>
                                                @else
                                                    <div class="text-sm" style="color: #94A3B8;">-</div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="background: #F8FAFC;">
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-sm font-semibold" style="color: #374151;">Total</td>
                                        <td class="px-4 py-3 text-right text-sm font-semibold" style="color: #059669;">
                                            Rp {{ number_format($journalEntry->total_debit, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 text-right text-sm font-semibold" style="color: #DC2626;">
                                            Rp {{ number_format($journalEntry->total_kredit, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center">
                                            @if($journalEntry->total_debit == $journalEntry->total_kredit)
                                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Balance ✓
                                                </span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Tidak Balance ✗
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="pt-4 border-t" style="border-color: #E2E8F0;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm" style="color: #64748B;">
                        <div>
                            <span class="font-medium">Dibuat:</span> {{ $journalEntry->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div>
                            <span class="font-medium">Terakhir diubah:</span> {{ $journalEntry->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 border-t flex flex-col sm:flex-row gap-3 sm:justify-end" style="background: #F8FAFC; border-color: #E2E8F0;">
                <form action="{{ route('journal-entries.destroy', $journalEntry) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jurnal ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all duration-200 transform hover:scale-105"
                            style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus Jurnal
                    </button>
                </form>
                <a href="{{ route('journal-entries.edit', $journalEntry) }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all duration-200 transform hover:scale-105"
                   style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Jurnal
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
