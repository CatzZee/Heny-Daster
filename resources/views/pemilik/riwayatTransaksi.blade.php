@extends('layouts.app')

@section('content')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    :root {
        --primary-color: #ff4da6;
        --primary-hover: #e04595;
        --bg-color: #f3f4f6;
        --text-muted: #6c757d;
    }

    body {
        background-color: var(--bg-color);
        font-family: 'Inter', sans-serif; /* Rekomendasi font modern */
    }

    /* Card Styling */
    .card-filter {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .transaction-card {
        border: none;
        border-radius: 12px;
        margin-bottom: 1rem;
        background: white;
        transition: all 0.2s ease-in-out;
        border-left: 4px solid transparent; /* Invisible border for consistency */
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .transaction-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-left-color: var(--primary-color);
    }

    /* Header Interaction */
    .card-header-custom {
        padding: 1.5rem;
        cursor: pointer;
        background: white;
        border-radius: 12px;
    }
    
    /* Chevron Animation */
    .chevron-icon {
        transition: transform 0.3s ease;
    }
    .transaction-card.expanded .chevron-icon {
        transform: rotate(180deg);
    }

    /* Collapsible Content */
    .transaction-details {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #fcfcfc;
        border-radius: 0 0 12px 12px;
    }
    
    .transaction-card.expanded .transaction-details {
        max-height: 2000px; /* Cukup besar untuk menampung konten */
        border-top: 1px solid #edf2f7;
    }

    /* Buttons & Badges */
    .btn-primary-custom {
        background-color:  #ff4da6;
        border-color:  #ff4da6;
        color: white;
        font-weight: 500;
    }
    .btn-primary-custom:hover {
        background-color:  #e04595;
        color: white;
    }

    .badge-soft {
        padding: 0.5em 0.8em;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .badge-tunai { background-color: #d1fae5; color: #065f46; }
    .badge-transfer { background-color: #dbeafe; color: #1e40af; }
    .badge-qris { background-color: #fef3c7; color: #92400e; }

    /* Typography */
    .text-amount {
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .table-details th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--text-muted);
        background-color: #f9fafb;
    }
    .table-details td {
        vertical-align: middle;
        font-size: 0.95rem;
    }

    /* Pagination Custom */
    .page-link-custom {
        color: var(--primary-color);
        border: 1px solid #dee2e6;
        margin: 0 2px;
        border-radius: 6px;
        padding: 6px 12px;
        text-decoration: none;
        display: inline-block;
    }
    .page-link-custom.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    .page-link-custom:hover:not(.active) {
        background-color: #fce7f3;
    }
</style>
@endpush

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Riwayat Transaksi</h2>
            <p class="text-muted mb-0">Pantau semua aktivitas penjualan Anda.</p>
        </div>
        </div>

    <div class="card card-filter mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ url()->current() }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">DARI TANGGAL</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted fw-bold">SAMPAI TANGGAL</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted fw-bold">PENCARIAN</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="ID Transaksi, Nama Pembeli..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end ">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 text-muted small">
        <div class="mb-2 mb-md-0">
            Menampilkan 
            <select class="form-select form-select-sm d-inline-block w-auto mx-1" onchange="window.location.href=this.value">
                @foreach([5, 10, 15, 25] as $num)
                    <option value="{{ request()->fullUrlWithQuery(['per_page' => $num]) }}" {{ request('per_page', 10) == $num ? 'selected' : '' }}>{{ $num }}</option>
                @endforeach
            </select>
            data per halaman
        </div>
        <div>
            Halaman {{ $transaksis->currentPage() }} dari {{ $transaksis->lastPage() }}
        </div>
    </div>

    <div id="transactionList">
        @forelse ($transaksis as $transaksi)
            <div class="transaction-card" id="card-{{ $transaksi->id }}">
                <div class="card-header-custom" onclick="toggleDetails('{{ $transaksi->id }}')">
                    <div class="row align-items-center">
                        <div class="col-6 col-md-3 mb-2 mb-md-0">
                            <span class="text-muted small d-block">ID Transaksi</span>
                            <span class="fw-bold text-dark">#{{ $transaksi->kode_transaksi }}</span>
                        </div>
                        <div class="col-6 col-md-3 mb-2 mb-md-0">
                            <span class="text-muted small d-block">Tanggal</span>
                            <span class="text-dark">{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->isoFormat('D MMM Y, HH:mm') }}</span>
                        </div>
                        <div class="col-6 col-md-2 mb-2 mb-md-0">
                            <span class="text-muted small d-block mb-1">Metode</span>
                            <span class="badge badge-soft badge-{{ strtolower($transaksi->metode_pembayaran) }}">
                                {{ $transaksi->metode_pembayaran }}
                            </span>
                        </div>
                        <div class="col-6 col-md-3 text-end">
                            <span class="text-muted small d-block">Total</span>
                            <span class="text-amount">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-1 text-end d-none d-md-block">
                            <i class="bi bi-chevron-down chevron-icon text-muted"></i>
                        </div>
                    </div>
                </div>

                <div class="transaction-details">
                    <div class="p-4">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="small text-muted fw-bold text-uppercase">Informasi Pembeli</h6>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="bg-light rounded-circle p-2 me-3">
                                        <i class="bi bi-person-fill text-secondary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $transaksi->nama_pembeli }}</div>
                                        <div class="small text-muted">Customer</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-details table-borderless">
                                <thead>
                                    <tr>
                                        <th style="width: 40%">Produk</th>
                                        <th class="text-center">Ukuran</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaksi->details as $d)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-semibold">{{ $d->produk->nama_produk ?? 'Produk Dihapus' }}</div>
                                                <small class="text-muted">{{ $d->produk->kode_produk ?? '-' }}</small>
                                            </td>
                                            <td class="text-center"><span class="badge bg-light text-dark border">{{ $d->produk->ukuran_baju ?? '-' }}</span></td>
                                            <td class="text-center">{{ $d->jumlah }}</td>
                                            <td class="text-end">Rp {{ number_format($d->harga_saat_transaksi, 0, ',', '.') }}</td>
                                            <td class="text-end fw-semibold">Rp {{ number_format($d->harga_saat_transaksi * $d->jumlah, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end pt-3 text-muted">Total Pembayaran</td>
                                        <td class="text-end pt-3 fw-bold fs-5 text-dark">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-2130356-1800917.png" alt="Empty" style="width: 150px; opacity: 0.5;">
                <p class="text-muted mt-3">Belum ada transaksi yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        @if ($transaksis->hasPages())
            <nav>
                <div class="d-flex gap-1">
                    {{-- Previous Page Link --}}
                    @if ($transaksis->onFirstPage())
                        <span class="page-link-custom text-muted" style="cursor: not-allowed; opacity: 0.6;"><i class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $transaksis->previousPageUrl() }}" class="page-link-custom"><i class="bi bi-chevron-left"></i></a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($transaksis->links()->elements as $element)
                        @if (is_string($element))
                            <span class="page-link-custom border-0">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $transaksis->currentPage())
                                    <span class="page-link-custom active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="page-link-custom">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($transaksis->hasMorePages())
                        <a href="{{ $transaksis->nextPageUrl() }}" class="page-link-custom"><i class="bi bi-chevron-right"></i></a>
                    @else
                        <span class="page-link-custom text-muted" style="cursor: not-allowed; opacity: 0.6;"><i class="bi bi-chevron-right"></i></span>
                    @endif
                </div>
            </nav>
        @endif
    </div>
</div>

<script>
    function toggleDetails(id) {
        const card = document.getElementById('card-' + id);
        card.classList.toggle('expanded');
    }
</script>

@endsection