@extends('layouts.app')

@section('title', 'Detail Akun')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">👁️ Detail Akun</h1>
                    <p class="text-muted mb-0">Informasi lengkap akun: <strong>{{ $account->nama_akun }}</strong></p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('accounts.edit', $account) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Account Info Card -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Informasi Akun</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Kode Akun</label>
                            <div class="fw-bold">
                                <span class="badge bg-light text-dark fs-6">{{ $account->kode_akun }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Nama Akun</label>
                            <div class="fw-bold">{{ $account->nama_akun }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tipe Akun</label>
                            <div>
                                @php
                                    $typeColors = [
                                        'aset' => 'primary',
                                        'liabilitas' => 'danger',
                                        'ekuitas' => 'success',
                                        'pendapatan' => 'info',
                                        'beban' => 'warning'
                                    ];
                                    $typeIcons = [
                                        'aset' => 'fas fa-coins',
                                        'liabilitas' => 'fas fa-credit-card',
                                        'ekuitas' => 'fas fa-chart-pie',
                                        'pendapatan' => 'fas fa-arrow-up',
                                        'beban' => 'fas fa-arrow-down'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $typeColors[$account->tipe_akun] ?? 'secondary' }} fs-6">
                                    <i class="{{ $typeIcons[$account->tipe_akun] ?? 'fas fa-question' }}"></i>
                                    {{ ucfirst($account->tipe_akun) }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Kategori</label>
                            <div>
                                @if($account->kategori)
                                    <span class="badge bg-light text-dark fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $account->kategori)) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Parent Account</label>
                            <div>
                                @if($account->parent_id)
                                    <span class="badge bg-light text-dark fs-6">{{ $account->parent_id }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Status</label>
                            <div>
                                @if($account->is_active)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check"></i> Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-times"></i> Tidak Aktif
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($account->deskripsi)
                        <div class="col-12">
                            <label class="form-label text-muted small">Deskripsi</label>
                            <div class="border rounded p-3 bg-light">{{ $account->deskripsi }}</div>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Dibuat Pada</label>
                            <div>{{ $account->created_at->format('d/m/Y H:i') }}</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Terakhir Diubah</label>
                            <div>{{ $account->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usage Statistics -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Statistik Penggunaan</h6>
                </div>
                <div class="card-body">
                    @php
                        $journalCount = $account->journalDetails()->count();
                        $openingBalanceCount = $account->openingBalances()->count();
                    @endphp

                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-primary">{{ $journalCount }}</div>
                                <div class="small text-muted">Transaksi Jurnal</div>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="border rounded p-3">
                                <div class="h4 mb-1 text-success">{{ $openingBalanceCount }}</div>
                                <div class="small text-muted">Saldo Awal</div>
                            </div>
                        </div>
                    </div>

                    @if($journalCount > 0 || $openingBalanceCount > 0)
                        <div class="alert alert-warning small">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Akun ini sudah digunakan dan tidak dapat dihapus.
                        </div>
                    @else
                        <div class="alert alert-success small">
                            <i class="fas fa-check-circle me-1"></i>
                            Akun belum digunakan dan dapat dihapus.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('accounts.edit', $account) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> Edit Akun
                        </a>

                        @if($journalCount == 0 && $openingBalanceCount == 0)
                            <button type="button" class="btn btn-outline-danger"
                                    onclick="confirmDelete('{{ $account->id }}', '{{ $account->nama_akun }}')">
                                <i class="fas fa-trash"></i> Hapus Akun
                            </button>
                        @endif

                        <a href="{{ route('accounts.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list"></i> Daftar Akun
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus akun <strong id="account-name"></strong>?</p>
                <p class="text-danger small mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Aksi ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" id="delete-form" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Delete confirmation
function confirmDelete(accountId, accountName) {
    document.getElementById('account-name').textContent = accountName;
    document.getElementById('delete-form').action = `/accounts/${accountId}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
@endsection
