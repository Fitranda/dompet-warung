@section('title', 'Buat Jurnal Umum')

<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
            <div class="min-w-0 flex-1">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold truncate" style="color: #0F172A;">Buat Jurnal Umum</h1>
                <p class="mt-1 flex items-center text-xs sm:text-sm" style="color: #334155;">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-2 flex-shrink-0" style="color: #14B8A6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="truncate">Buat transaksi jurnal umum baru</span>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-6 xl:px-8">
        <!-- Template Info Banner (if coming from template) -->
        @if(isset($templateData) && isset($templateData['title']))
        <div class="mb-4 sm:mb-6 bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <h3 class="text-xs sm:text-sm font-medium text-blue-800">
                        Template: {{ $templateData['title'] }}
                    </h3>
                    <p class="mt-1 text-xs text-blue-700">
                        {{ $templateData['description'] }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="mb-4 sm:mb-6 flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ route('journal-entries.quick-templates') }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border hover:shadow-md hover:scale-[1.02]"
               style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Jurnal Singkat</span>
            </a>
            <a href="{{ route('journal-entries.index') }}"
               class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 border hover:shadow-md hover:scale-[1.02]"
               style="color: #64748B; border-color: #E2E8F0; background: white;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Daftar Jurnal</span>
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 15.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
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
            <div class="px-6 py-4 border-b"
                style="background: linear-gradient(135deg, #F8FAFC 0%, #E2E8F0 100%); border-color: #E2E8F0;">
                <div class="flex items-center">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3"
                        style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold" style="color: #0F172A;">Form Jurnal Umum</h3>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('journal-entries.store') }}" method="POST" id="journalForm">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div>
                            <label for="tanggal" class="block text-sm font-medium mb-2"
                                style="color: #374151;">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal"
                                value="{{ old('tanggal', date('Y-m-d')) }}" required
                                class="w-full px-3 py-2.5 rounded-lg border transition-colors duration-200 text-sm focus:outline-none focus:ring-2"
                                style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;">
                        </div>

                        <!-- Auto-generated Journal Number Display -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: #374151;">No. Jurnal</label>
                            <div class="w-full px-3 py-2.5 rounded-lg border bg-gray-50 text-sm"
                                style="border-color: #D1D5DB; color: #6B7280;">
                                Akan dibuat otomatis
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-medium mb-2"
                            style="color: #374151;">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3" required placeholder="Masukkan keterangan transaksi..."
                            class="w-full px-3 py-2.5 rounded-lg border transition-colors duration-200 text-sm focus:outline-none focus:ring-2"
                            style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;">{{ old('keterangan', isset($templateData['title']) ? $templateData['description'] : '') }}</textarea>
                    </div>

                <!-- Journal Details -->
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4 mb-4">
                        <label class="block text-sm font-medium" style="color: #374151;">Detail Jurnal</label>
                        <button type="button" onclick="addJournalDetail()"
                            class="inline-flex items-center justify-center px-3 py-2 rounded-lg text-xs sm:text-sm font-medium text-white transition-all duration-200 hover:scale-105 w-full sm:w-auto"
                            style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Baris
                        </button>
                    </div>

                    <!-- Journal Details - Mobile View -->
                    <div class="block sm:hidden space-y-3" id="journalDetailsMobile">
                        <!-- Mobile cards will be generated by JavaScript -->
                    </div>

                    <!-- Journal Details - Desktop Table -->
                    <div class="hidden sm:block border rounded-lg overflow-hidden" style="border-color: #E2E8F0;">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y" style="divide-color: #E2E8F0;">
                                <thead style="background: #F8FAFC;">
                                    <tr>
                                        <th class="px-3 lg:px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                            style="color: #64748B;">Akun</th>
                                        <th class="px-3 lg:px-4 py-3 text-right text-xs font-medium uppercase tracking-wider"
                                            style="color: #64748B;">Debet</th>
                                        <th class="px-3 lg:px-4 py-3 text-right text-xs font-medium uppercase tracking-wider"
                                            style="color: #64748B;">Kredit</th>
                                        <th class="px-3 lg:px-4 py-3 text-center text-xs font-medium uppercase tracking-wider"
                                            style="color: #64748B;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="journalDetails" class="divide-y" style="divide-color: #E2E8F0;">
                                    <!-- Initial 2 rows will be added by JavaScript -->
                                </tbody>
                                <tfoot style="background: #F8FAFC;">
                                    <tr>
                                        <td class="px-3 lg:px-4 py-3 text-sm font-semibold" style="color: #374151;">Total</td>
                                        <td class="px-3 lg:px-4 py-3 text-right text-sm font-semibold"
                                            style="color: #059669;">
                                            <span class="hidden sm:inline">Rp </span><span id="totalDebet">0</span>
                                        </td>
                                        <td class="px-3 lg:px-4 py-3 text-right text-sm font-semibold"
                                            style="color: #DC2626;">
                                            <span class="hidden sm:inline">Rp </span><span id="totalKredit">0</span>
                                        </td>
                                        <td class="px-3 lg:px-4 py-3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Balance Status - Shared for both mobile and desktop -->
                    <div class="mt-3 sm:mt-0 sm:bg-gray-50 sm:border-t sm:px-4 sm:py-3 text-center" style="border-color: #E2E8F0;">
                        <span id="balanceStatus" class="inline-block px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Belum balance
                        </span>
                    </div>
                </div>
                </div>

                <!-- Form Actions -->
                <div class="px-3 sm:px-6 py-4 border-t flex flex-col sm:flex-row gap-3 sm:justify-end"
                    style="background: #F8FAFC; border-color: #E2E8F0;">
                    <a href="{{ route('journal-entries.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 border order-2 sm:order-1"
                        style="color: #64748B; border-color: #E2E8F0; background: white;">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" id="submitBtn" disabled
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed order-1 sm:order-2"
                        style="background: linear-gradient(135deg, #14B8A6 0%, #0F766E 100%);">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Jurnal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let detailIndex = 0;
        const accounts = @json($accounts);

        function addJournalDetail() {
            // Add to desktop table
            addDesktopRow();
            // Add to mobile view
            addMobileCard();
            detailIndex++;
        }

        function addDesktopRow() {
            const tbody = document.getElementById('journalDetails');
            const row = document.createElement('tr');
            row.setAttribute('data-index', detailIndex);
            row.innerHTML = `
                <td class="px-3 lg:px-4 py-3">
                    <select name="details[${detailIndex}][account_id]"
                            class="w-full px-2 py-2 rounded-lg border text-xs sm:text-sm focus:outline-none focus:ring-2"
                            style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                            onchange="calculateTotals(); syncMobileCard(${detailIndex})" required>
                        <option value="">Pilih Akun</option>
                        ${accounts.map(account =>
                            `<option value="${account.id}">${account.kode_akun} - ${account.nama_akun}</option>`
                        ).join('')}
                    </select>
                </td>
                <td class="px-3 lg:px-4 py-3">
                    <input type="number"
                           name="details[${detailIndex}][debet]"
                           step="0.01"
                           min="0"
                           placeholder="0"
                           class="w-full px-2 py-2 rounded-lg border text-xs sm:text-sm text-right focus:outline-none focus:ring-2"
                           style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                           onchange="calculateTotals(); syncMobileCard(${detailIndex})"
                           oninput="clearKredit(this)">
                </td>
                <td class="px-3 lg:px-4 py-3">
                    <input type="number"
                           name="details[${detailIndex}][kredit]"
                           step="0.01"
                           min="0"
                           placeholder="0"
                           class="w-full px-2 py-2 rounded-lg border text-xs sm:text-sm text-right focus:outline-none focus:ring-2"
                           style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                           onchange="calculateTotals(); syncMobileCard(${detailIndex})"
                           oninput="clearDebet(this)">
                </td>
                <td class="px-3 lg:px-4 py-3 text-center">
                    <button type="button"
                            onclick="removeJournalDetail(${detailIndex})"
                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white transition-all duration-200"
                            style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        }

        function addMobileCard() {
            const mobileContainer = document.getElementById('journalDetailsMobile');
            const card = document.createElement('div');
            card.setAttribute('data-index', detailIndex);
            card.className = 'bg-white border border-gray-200 rounded-lg p-3 space-y-3';
            card.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-500">Baris ${detailIndex + 1}</span>
                    <button type="button"
                            onclick="removeJournalDetail(${detailIndex})"
                            class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white"
                            style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Akun</label>
                    <select name="details[${detailIndex}][account_id]"
                            class="w-full px-3 py-2 rounded-lg border text-sm focus:outline-none focus:ring-2"
                            style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                            onchange="calculateTotals(); syncDesktopRow(${detailIndex})" required>
                        <option value="">Pilih Akun</option>
                        ${accounts.map(account =>
                            `<option value="${account.id}">${account.kode_akun} - ${account.nama_akun}</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Debet</label>
                        <input type="number"
                               name="details[${detailIndex}][debet]"
                               step="0.01"
                               min="0"
                               placeholder="0"
                               class="w-full px-3 py-2 rounded-lg border text-sm text-right focus:outline-none focus:ring-2"
                               style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                               onchange="calculateTotals(); syncDesktopRow(${detailIndex})"
                               oninput="clearKreditMobile(this, ${detailIndex})">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Kredit</label>
                        <input type="number"
                               name="details[${detailIndex}][kredit]"
                               step="0.01"
                               min="0"
                               placeholder="0"
                               class="w-full px-3 py-2 rounded-lg border text-sm text-right focus:outline-none focus:ring-2"
                               style="border-color: #D1D5DB; focus:border-color: #14B8A6; focus:ring-color: #14B8A6;"
                               onchange="calculateTotals(); syncDesktopRow(${detailIndex})"
                               oninput="clearKreditMobile(this, ${detailIndex})">
                    </div>
                </div>
            `;
            mobileContainer.appendChild(card);
        }

        function syncDesktopRow(index) {
            const mobileCard = document.querySelector(`#journalDetailsMobile [data-index="${index}"]`);
            const desktopRow = document.querySelector(`#journalDetails [data-index="${index}"]`);

            if (mobileCard && desktopRow) {
                const mobileAccount = mobileCard.querySelector('select').value;
                const mobileDebet = mobileCard.querySelector('input[name*="[debet]"]').value;
                const mobileKredit = mobileCard.querySelector('input[name*="[kredit]"]').value;

                desktopRow.querySelector('select').value = mobileAccount;
                desktopRow.querySelector('input[name*="[debet]"]').value = mobileDebet;
                desktopRow.querySelector('input[name*="[kredit]"]').value = mobileKredit;
            }
        }

        function syncMobileCard(index) {
            const desktopRow = document.querySelector(`#journalDetails [data-index="${index}"]`);
            const mobileCard = document.querySelector(`#journalDetailsMobile [data-index="${index}"]`);

            if (desktopRow && mobileCard) {
                const desktopAccount = desktopRow.querySelector('select').value;
                const desktopDebet = desktopRow.querySelector('input[name*="[debet]"]').value;
                const desktopKredit = desktopRow.querySelector('input[name*="[kredit]"]').value;

                mobileCard.querySelector('select').value = desktopAccount;
                mobileCard.querySelector('input[name*="[debet]"]').value = desktopDebet;
                mobileCard.querySelector('input[name*="[kredit]"]').value = desktopKredit;
            }
        }

        function removeJournalDetail(index) {
            const tbody = document.getElementById('journalDetails');
            const mobileContainer = document.getElementById('journalDetailsMobile');

            if (tbody.children.length > 2) {
                // Remove from desktop table
                const desktopRow = document.querySelector(`#journalDetails [data-index="${index}"]`);
                if (desktopRow) desktopRow.remove();

                // Remove from mobile view
                const mobileCard = document.querySelector(`#journalDetailsMobile [data-index="${index}"]`);
                if (mobileCard) mobileCard.remove();

                calculateTotals();
            } else {
                alert('Minimal harus ada 2 baris detail jurnal');
            }
        }

        function clearDebet(kreditInput) {
            const row = kreditInput.closest('tr');
            const debetInput = row.querySelector('input[name*="[debet]"]');
            const index = row.getAttribute('data-index');

            if (kreditInput.value && parseFloat(kreditInput.value) > 0) {
                debetInput.value = '';
                // Sync to mobile
                const mobileCard = document.querySelector(`#journalDetailsMobile [data-index="${index}"]`);
                if (mobileCard) {
                    mobileCard.querySelector('input[name*="[debet]"]').value = '';
                }
            }
        }

        function clearKredit(debetInput) {
            const row = debetInput.closest('tr');
            const kreditInput = row.querySelector('input[name*="[kredit]"]');
            const index = row.getAttribute('data-index');

            if (debetInput.value && parseFloat(debetInput.value) > 0) {
                kreditInput.value = '';
                // Sync to mobile
                const mobileCard = document.querySelector(`#journalDetailsMobile [data-index="${index}"]`);
                if (mobileCard) {
                    mobileCard.querySelector('input[name*="[kredit]"]').value = '';
                }
            }
        }

        function clearDebetMobile(kreditInput, index) {
            const mobileCard = kreditInput.closest('[data-index]');
            const debetInput = mobileCard.querySelector('input[name*="[debet]"]');

            if (kreditInput.value && parseFloat(kreditInput.value) > 0) {
                debetInput.value = '';
                syncDesktopRow(index);
            }
        }

        function clearKreditMobile(debetInput, index) {
            const mobileCard = debetInput.closest('[data-index]');
            const kreditInput = mobileCard.querySelector('input[name*="[kredit]"]');

            if (debetInput.value && parseFloat(debetInput.value) > 0) {
                kreditInput.value = '';
                syncDesktopRow(index);
            }
        }

        function calculateTotals() {
            let totalDebet = 0;
            let totalKredit = 0;

            // Only count from desktop table to avoid double counting
            document.querySelectorAll('#journalDetails input[name*="[debet]"]').forEach(input => {
                if (input.value) {
                    totalDebet += parseFloat(input.value);
                }
            });

            document.querySelectorAll('#journalDetails input[name*="[kredit]"]').forEach(input => {
                if (input.value) {
                    totalKredit += parseFloat(input.value);
                }
            });

            document.getElementById('totalDebet').textContent = totalDebet.toLocaleString('id-ID');
            document.getElementById('totalKredit').textContent = totalKredit.toLocaleString('id-ID');

            const balanceStatus = document.getElementById('balanceStatus');
            const submitBtn = document.getElementById('submitBtn');

            if (totalDebet === totalKredit && totalDebet > 0) {
                balanceStatus.textContent = 'Balance ✓';
                balanceStatus.className = 'inline-block px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800';
                submitBtn.disabled = false;
            } else if (totalDebet === 0 && totalKredit === 0) {
                balanceStatus.textContent = 'Belum ada nilai';
                balanceStatus.className = 'inline-block px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800';
                submitBtn.disabled = true;
            } else {
                balanceStatus.textContent = 'Tidak balance ✗';
                balanceStatus.className = 'inline-block px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800';
                submitBtn.disabled = true;
            }
        }

        // Initialize with 2 rows
        document.addEventListener('DOMContentLoaded', function() {
            addJournalDetail();
            addJournalDetail();

            // Pre-fill template data if available
            @if (isset($templateData) && isset($templateData['accounts']))
                const templateAccounts = @json($templateData['accounts']);
                prefillTemplateData(templateAccounts);
            @endif
        });

        // Function to prefill template data
        function prefillTemplateData(templateAccounts) {
            const desktopRows = document.querySelectorAll('#journalDetails tr');
            const mobileCards = document.querySelectorAll('#journalDetailsMobile > div');

            templateAccounts.forEach((account, index) => {
                if (index < desktopRows.length && account.account_id) {
                    // Fill desktop
                    const desktopRow = desktopRows[index];
                    const accountSelect = desktopRow.querySelector('select[name*="[account_id]"]');
                    if (accountSelect) {
                        accountSelect.value = account.account_id;
                        accountSelect.dispatchEvent(new Event('change'));
                    }

                    // Fill mobile
                    if (index < mobileCards.length) {
                        const mobileCard = mobileCards[index];
                        const mobileSelect = mobileCard.querySelector('select[name*="[account_id]"]');
                        if (mobileSelect) {
                            mobileSelect.value = account.account_id;
                            mobileSelect.dispatchEvent(new Event('change'));
                        }
                    }
                }
            });
        }
    </script>

    <style>
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .max-w-6xl {
                max-width: 100%;
            }

            /* Optimize form inputs for mobile */
            select, input[type="number"], input[type="date"], textarea {
                font-size: 16px !important; /* Prevent zoom on iOS */
                -webkit-appearance: none;
            }

            /* Improve touch targets */
            button, .button, a.button {
                min-height: 44px;
                touch-action: manipulation;
            }

            /* Optimize select dropdown */
            select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem;
            }

            /* Mobile specific spacing */
            .space-y-3 > * + * {
                margin-top: 0.75rem;
            }
        }

        /* Additional mobile-first responsive adjustments */
        @media (max-width: 375px) {
            /* Extra small mobile devices */
            .px-2 {
                padding-left: 0.25rem;
                padding-right: 0.25rem;
            }

            .text-xs {
                font-size: 0.625rem;
            }

            .gap-3 {
                gap: 0.5rem;
            }
        }

        /* Ensure proper form validation styling */
        input:invalid, select:invalid, textarea:invalid {
            border-color: #EF4444 !important;
            box-shadow: 0 0 0 1px #EF4444 !important;
        }

        input:valid, select:valid, textarea:valid {
            border-color: #10B981 !important;
        }

        /* Loading state for buttons */
        button:disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Better focus states for accessibility */
        input:focus, select:focus, textarea:focus, button:focus {
            outline: 2px solid #14B8A6;
            outline-offset: 2px;
        }
    </style>
</x-admin-layout>
