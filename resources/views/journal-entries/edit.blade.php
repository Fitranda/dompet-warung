@section('title', 'Edit Jurnal Umum')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl md:text-3xl font-bold" style="color: #0F172A;">Edit Jurnal Umum</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm md:text-base" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit transaksi jurnal umum: {{ $journalEntry->no_jurnal }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <a href="{{ route('journal-entries.show', $journalEntry) }}"
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
        <!-- Error Messages -->
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-lg border overflow-hidden" style="border-color: #E2E8F0;">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b" style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Edit Jurnal: {{ $journalEntry->no_jurnal }}</h3>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('journal-entries.update', $journalEntry) }}" method="POST" id="journalForm">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium mb-2" style="color: #374151;">Tanggal</label>
                            <input type="date"
                                   id="tanggal"
                                   name="tanggal"
                                   value="{{ old('tanggal', $journalEntry->tanggal->format('Y-m-d')) }}"
                                   required
                                   class="w-full px-3 py-2.5 rounded-lg border transition-colors duration-200 text-sm focus:outline-none focus:ring-2"
                                   style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;">
                        </div>

                        <!-- Journal Number Display -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: #374151;">No. Jurnal</label>
                            <div class="w-full px-3 py-2.5 rounded-lg border bg-gray-50 text-sm" style="border-color: #D1D5DB; color: #6B7280;">
                                {{ $journalEntry->no_jurnal }}
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-medium mb-2" style="color: #374151;">Keterangan</label>
                        <textarea id="keterangan"
                                  name="keterangan"
                                  rows="3"
                                  required
                                  placeholder="Masukkan keterangan transaksi..."
                                  class="w-full px-3 py-2.5 rounded-lg border transition-colors duration-200 text-sm focus:outline-none focus:ring-2"
                                  style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;">{{ old('keterangan', $journalEntry->keterangan) }}</textarea>
                    </div>

                    <!-- Journal Details -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium" style="color: #374151;">Detail Jurnal</label>
                            <button type="button"
                                    onclick="addJournalDetail()"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-white transition-all duration-200 hover:scale-105"
                                    style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Baris
                            </button>
                        </div>

                        <!-- Journal Details Table -->
                        <div class="border rounded-lg overflow-hidden" style="border-color: #E2E8F0;">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y" style="divide-color: #E2E8F0;">
                                    <thead style="background: #F8FAFC;">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Akun</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Debit</th>
                                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Kredit</th>
                                            <th class="px-4 py-3 text-center text-xs font-medium uppercase tracking-wider" style="color: #64748B;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="journalDetails" class="divide-y" style="divide-color: #E2E8F0;">
                                        <!-- Existing details will be populated by JavaScript -->
                                    </tbody>
                                    <tfoot style="background: #F8FAFC;">
                                        <tr>
                                            <td class="px-4 py-3 text-sm font-semibold" style="color: #374151;">Total</td>
                                            <td class="px-4 py-3 text-right text-sm font-semibold" style="color: #059669;">
                                                Rp <span id="totalDebit">0</span>
                                            </td>
                                            <td class="px-4 py-3 text-right text-sm font-semibold" style="color: #DC2626;">
                                                Rp <span id="totalKredit">0</span>
                                            </td>
                                            <td class="px-4 py-3"></td>
                                        </tr>
                                        <tr id="balanceRow">
                                            <td colspan="4" class="px-4 py-2 text-center text-sm">
                                                <span id="balanceStatus" class="px-3 py-1 rounded-full text-xs font-medium">
                                                    Belum balance
                                                </span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 border-t flex flex-col sm:flex-row gap-3 sm:justify-end" style="background: #F8FAFC; border-color: #E2E8F0;">
                    <a href="{{ route('journal-entries.show', $journalEntry) }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 border"
                       style="color: #64748B; border-color: #E2E8F0; background: white;">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            id="submitBtn"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Update Jurnal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let detailIndex = 0;
        const accounts = @json($accounts);
        const existingDetails = @json($journalEntry->details);

        function addJournalDetail(accountId = '', debit = '', kredit = '') {
            const tbody = document.getElementById('journalDetails');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-4 py-3">
                    <select name="details[${detailIndex}][account_id]"
                            class="w-full px-3 py-2 rounded-lg border text-sm focus:outline-none focus:ring-2"
                            style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                            onchange="calculateTotals()" required>
                        <option value="">Pilih Akun</option>
                        ${accounts.map(account =>
                            `<option value="${account.id}" ${account.id == accountId ? 'selected' : ''}>${account.kode_akun} - ${account.nama_akun}</option>`
                        ).join('')}
                    </select>
                </td>
                <td class="px-4 py-3">
                    <input type="number"
                           name="details[${detailIndex}][debit]"
                           step="0.01"
                           min="0"
                           value="${debit}"
                           placeholder="0"
                           class="w-full px-3 py-2 rounded-lg border text-sm text-right focus:outline-none focus:ring-2"
                           style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                           onchange="calculateTotals()"
                           oninput="clearKredit(this)">
                </td>
                <td class="px-4 py-3">
                    <input type="number"
                           name="details[${detailIndex}][kredit]"
                           step="0.01"
                           min="0"
                           value="${kredit}"
                           placeholder="0"
                           class="w-full px-3 py-2 rounded-lg border text-sm text-right focus:outline-none focus:ring-2"
                           style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                           onchange="calculateTotals()"
                           oninput="clearDebit(this)">
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button"
                            onclick="removeJournalDetail(this)"
                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white transition-all duration-200 hover:scale-105"
                            style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            detailIndex++;
        }

        function removeJournalDetail(button) {
            const tbody = document.getElementById('journalDetails');
            if (tbody.children.length > 2) {
                button.closest('tr').remove();
                calculateTotals();
            } else {
                alert('Minimal harus ada 2 baris detail jurnal');
            }
        }

        function clearDebit(kreditInput) {
            const row = kreditInput.closest('tr');
            const debitInput = row.querySelector('input[name*="[debit]"]');
            if (kreditInput.value && parseFloat(kreditInput.value) > 0) {
                debitInput.value = '';
            }
        }

        function clearKredit(debitInput) {
            const row = debitInput.closest('tr');
            const kreditInput = row.querySelector('input[name*="[kredit]"]');
            if (debitInput.value && parseFloat(debitInput.value) > 0) {
                kreditInput.value = '';
            }
        }

        function calculateTotals() {
            let totalDebit = 0;
            let totalKredit = 0;

            document.querySelectorAll('input[name*="[debit]"]').forEach(input => {
                if (input.value) {
                    totalDebit += parseFloat(input.value);
                }
            });

            document.querySelectorAll('input[name*="[kredit]"]').forEach(input => {
                if (input.value) {
                    totalKredit += parseFloat(input.value);
                }
            });

            document.getElementById('totalDebit').textContent = totalDebit.toLocaleString('id-ID');
            document.getElementById('totalKredit').textContent = totalKredit.toLocaleString('id-ID');

            const balanceStatus = document.getElementById('balanceStatus');
            const submitBtn = document.getElementById('submitBtn');

            if (totalDebit === totalKredit && totalDebit > 0) {
                balanceStatus.textContent = 'Balance ✓';
                balanceStatus.className = 'px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                submitBtn.disabled = false;
            } else if (totalDebit === 0 && totalKredit === 0) {
                balanceStatus.textContent = 'Belum ada nilai';
                balanceStatus.className = 'px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                submitBtn.disabled = true;
            } else {
                balanceStatus.textContent = 'Tidak balance ✗';
                balanceStatus.className = 'px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                submitBtn.disabled = true;
            }
        }

        // Initialize with existing details
        document.addEventListener('DOMContentLoaded', function() {
            // Add existing details
            existingDetails.forEach(detail => {
                addJournalDetail(detail.account_id, detail.debit, detail.kredit);
            });

            // If no existing details, add 2 empty rows
            if (existingDetails.length === 0) {
                addJournalDetail();
                addJournalDetail();
            }

            // Calculate initial totals
            calculateTotals();
        });
    </script>
</x-admin-layout>
