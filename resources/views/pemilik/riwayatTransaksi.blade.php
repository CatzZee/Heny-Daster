@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #f8f9fa;
        min-height: 100vh;
    }
    
    .transaction-item {
        background: white;
        border-left: 5px solid #ff4da6;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: 1px solid #e9ecef;
    }
    
    .transaction-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .transaction-details {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }
    
    .transaction-item.expanded .transaction-details {
        max-height: 1000px;
    }
    
    .badge-tunai { background-color: #d4edda; color: #155724; }
    .badge-transfer { background-color: #d1ecf1; color: #0c5460; }
    .badge-qris { background-color: #fff3cd; color: #856404; }
    
    .btn-filter {
        background: linear-gradient(135deg, #ff4da6 0%, #ff80bf 100%);
        border: none;
    }
    
    .btn-filter:hover {
        background: linear-gradient(135deg, #e04595 0%, #e572ab 100%);
    }
    
    .page-btn {
        border: 2px solid #ffb3d9;
        color: #ff4da6;
        background: white;
    }
    
    .page-btn:hover {
        background-color: #ffe6f3;
    }
    
    .page-btn.active {
        background-color: #ff4da6;
        border-color: #ff4da6;
        color: white;
    }
    
    .page-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .card {
        background-color: white;
        border: 1px solid #e9ecef;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .card-header-riwayat {
        background: linear-gradient(135deg, #ff4da6 0%, #ff80bf 100%);
        color: white;
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .card-header-riwayat h1 {
        margin: 0;
        font-weight: 600;
    }
    
    .main-content {
        background: transparent;
    }
    
    .form-control:focus {
        border-color: #ff80bf;
        box-shadow: 0 0 0 0.2rem rgba(255, 128, 191, 0.25);
    }
    
    .input-group-text {
        background-color: white;
        border-color: #ced4da;
    }
    
    .btn-outline-success {
        border-color: #28a745;
        color: #28a745;
    }
    
    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11 main-content p-4">
            <!-- Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-header-riwayat">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        Riwayat Transaksi
                    </h1>
                </div>
                <div class="card-body p-4">
                    <!-- Filter Section -->
                    <form method="GET" action="{{ url()->current() }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label"><i class="bi bi-calendar-event me-1"></i>Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label"><i class="bi bi-calendar-check me-1"></i>Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><i class="bi bi-search me-1"></i>Pencarian</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-search" style="color: #ff4da6;"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control" placeholder="Cari nama pembeli, produk,..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-filter text-white w-100">
                                    <i class="bi bi-funnel me-1"></i>Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Control Panel -->
            <div class="card shadow-sm mb-3">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted">Tampilkan:</span>
                                <form method="GET" action="{{ url()->current() }}" id="perPageForm">
                                    @if(request('start_date'))
                                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                                    @endif
                                    @if(request('end_date'))
                                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                                    @endif
                                    @if(request('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    <select name="per_page" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
                                        <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                        <option value="15" {{ request('per_page', 10) == 15 ? 'selected' : '' }}>15</option>
                                        <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20</option>
                                        <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                    </select>
                                </form>
                                <span class="text-muted">data per halaman</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end gap-1">
                                <!-- Prev Button -->
                                @if ($transaksis->currentPage() > 1)
                                    <a href="{{ $transaksis->appends(request()->query())->previousPageUrl() }}" class="btn btn-sm page-btn">
                                        <i class="bi bi-chevron-left"></i> Prev
                                    </a>
                                @else
                                    <button class="btn btn-sm page-btn" disabled>
                                        <i class="bi bi-chevron-left"></i> Prev
                                    </button>
                                @endif

                                <!-- Page Numbers -->
                                @php
                                    $start = max(1, $transaksis->currentPage() - 2);
                                    $end = min($transaksis->lastPage(), $transaksis->currentPage() + 2);
                                @endphp

                                @if($start > 1)
                                    <a href="{{ $transaksis->appends(request()->query())->url(1) }}" class="btn btn-sm page-btn">1</a>
                                    @if($start > 2)
                                        <button class="btn btn-sm page-btn" disabled>...</button>
                                    @endif
                                @endif

                                @for($i = $start; $i <= $end; $i++)
                                    <a href="{{ $transaksis->appends(request()->query())->url($i) }}" class="btn btn-sm page-btn {{ $i == $transaksis->currentPage() ? 'active' : '' }}">
                                        {{ $i }}
                                    </a>
                                @endfor

                                @if($end < $transaksis->lastPage())
                                    @if($end < $transaksis->lastPage() - 1)
                                        <button class="btn btn-sm page-btn" disabled>...</button>
                                    @endif
                                    <a href="{{ $transaksis->appends(request()->query())->url($transaksis->lastPage()) }}" class="btn btn-sm page-btn">{{ $transaksis->lastPage() }}</a>
                                @endif

                                <!-- Next Button -->
                                @if ($transaksis->hasMorePages())
                                    <a href="{{ $transaksis->appends(request()->query())->nextPageUrl() }}" class="btn btn-sm page-btn">
                                        Next <i class="bi bi-chevron-right"></i>
                                    </a>
                                @else
                                    <button class="btn btn-sm page-btn" disabled>
                                        Next <i class="bi bi-chevron-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction List -->
            <div id="transactionList">
                @forelse ($transaksis as $transaksi)
                    <div class="card transaction-item mb-3" onclick="this.classList.toggle('expanded')">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="text-muted small">#{{ $transaksi->kode_transaksi }}</div>
                                    <div class="text-muted mb-2">{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->isoFormat('dddd, D MMMM Y') }}</div>
                                    <div class="mb-2">
                                        <strong class="me-2">{{ $transaksi->nama_pembeli }}</strong>
                                        <span class="badge badge-{{ strtolower($transaksi->metode_pembayaran) }}">{{ $transaksi->metode_pembayaran }}</span>
                                    </div>
                                    <div class="h5 mb-0" style="color: #ff4da6;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <i class="bi bi-chevron-down" style="color: #ff4da6;"></i>
                                </div>
                            </div>
                            
                            <div class="transaction-details mt-3 pt-3 border-top">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-person me-1"></i>Pembeli:</strong><br>
                                        {{ $transaksi->nama_pembeli }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong><i class="bi bi-credit-card me-1"></i>Metode:</strong><br>
                                        <span class="badge badge-{{ strtolower($transaksi->metode_pembayaran) }}">{{ $transaksi->metode_pembayaran }}</span>
                                    </div>
                                </div>
                                
                                <table class="table table-sm table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Produk</th>
                                            <th>Ukuran</th>
                                            <th>Jumlah</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi->details as $d)
                                            <tr>
                                                <td>{{ $d->produk->nama_produk ?? 'N/A' }}</td>
                                                <td>{{ $d->produk->ukuran_baju ?? 'N/A' }}</td>
                                                <td>{{ $d->jumlah }}</td>
                                                <td>Rp {{ number_format($d->harga_saat_transaksi, 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($d->harga_saat_transaksi * $d->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                    <div>
                                        <!-- Tombol Cetak Struk -->
                                        <a href="{{ route('transaksi.cetakStruk', $transaksi->kode_transaksi) }}" 
                                           target="_blank"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-printer me-1"></i>Cetak Ulang Struk
                                        </a>
                                    </div>
                                    <strong class="h4" style="color: #ff4da6;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">Tidak ada data transaksi</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection