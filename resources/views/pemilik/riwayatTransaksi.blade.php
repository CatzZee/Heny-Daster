@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@push('styles')
<style>
    /* CSS Khusus untuk Halaman Riwayat Transaksi */
    
    /* Card Styling */
    .transaction-card {
      position: relative;
      background-color: transparent;
      border-radius: 12px;
      overflow: hidden;
      transition: 0.3s;
      border: 2px solid #ffb6c1;
      cursor: pointer; /* Menandakan bisa diklik */
    }

    .transaction-card .card-body {
      background-color: #fff;
      border-radius: 12px;
      padding: 15px 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .transaction-card .icon-box {
      background-color: #ffb6c1;
      color: white;
      font-size: 22px;
      font-weight: bold;
      border-radius: 10px;
      padding: 10px 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
    }

    .text-pink {
      color: #ff69b4;
    }

    /* Hover effects */
    .transaction-card:hover .card-body {
      background-color: #ffb6c1;
      color: white;
      transform: scale(1.02);
    }

    /* Sembunyikan konten teks saat hover */
    .transaction-card:hover .card-body .content-wrapper {
      opacity: 0;
    }

    /* Tampilkan tombol delete saat hover */
    .transaction-card .delete-overlay {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      z-index: 10;
      pointer-events: none; /* Agar klik tembus ke card wrapper kecuali tombolnya */
    }

    .transaction-card:hover .delete-overlay {
      opacity: 1;
      pointer-events: auto;
    }

    /* Tombol Delete Reset */
    .btn-delete {
      background: none;
      border: none;
      color: white;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      padding: 20px;
      transition: transform 0.2s;
    }

    .btn-delete:hover {
        transform: scale(1.2);
    }
    
    /* Pagination Custom */
    .pagination .page-item .page-link {
        color: #ff69b4;
    }
    .pagination .page-item.active .page-link {
        background-color: #ff69b4;
        border-color: #ff69b4;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h3 class="text-pink fw-bold m-0">Riwayat Transaksi</h3>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    {{-- Fitur Filter Tanggal --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="start_date" class="form-label text-muted fw-bold small">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end_date" class="form-label text-muted fw-bold small">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary bg-gradient text-white border-0 flex-grow-1" style="background-color: #ff69b4;">
                                <i class="bi bi-filter"></i> Filter
                            </button>
                            <a href="{{ url()->current() }}" class="btn btn-secondary flex-grow-1">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar Transaksi --}}
    @forelse($transaksis as $transaksi)
    {{-- Atribut data-bs-toggle untuk membuka modal saat card diklik --}}
    <div class="card transaction-card mb-3" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $transaksi->id }}">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center w-100 content-wrapper">
            <div class="d-flex align-items-center">
              <div class="icon-box me-3">
                  <i class="bi bi-cash-coin"></i>
              </div>
              <div>
                <strong>{{ $transaksi->nama_pembeli ?? $transaksi->kode_transaksi }}</strong><br>
                <small class="text-muted">{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->translatedFormat('d F Y H:i') }}</small>
              </div>
            </div>
    
            <div class="text-end text-pink fw-bold">
              + Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </div>
        </div>
      </div>

      <div class="delete-overlay">
        <form action="{{ route('pemilik.riwayat-transaksi.destroy', $transaksi->id) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus riwayat transaksi ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete" title="Hapus Transaksi" onclick="event.stopPropagation()">
                <i class="bi bi-trash"></i>
            </button>
        </form>
      </div>
    </div>

    {{-- Modal Detail Transaksi (Per Item Loop) --}}
    <div class="modal fade" id="modalDetail{{ $transaksi->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $transaksi->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="modalLabel{{ $transaksi->id }}">
                        Detail Transaksi: {{ $transaksi->kode_transaksi }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 border-bottom pb-2">
                        <div class="row">
                            <div class="col-6 text-muted">Tanggal</div>
                            <div class="col-6 text-end fw-bold">{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->translatedFormat('d F Y H:i') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-muted">Kasir</div>
                            <div class="col-6 text-end">{{ $transaksi->pengguna->name ?? '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-muted">Pembeli</div>
                            <div class="col-6 text-end">{{ $transaksi->nama_pembeli ?? 'Umum' }}</div>
                        </div>
                    </div>

                    <h6 class="fw-bold mb-2">Item Dibeli</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-borderless">
                            <thead class="text-muted small">
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi->details as $detail)
                                <tr>
                                    <td>{{ $detail->produk->nama_produk ?? 'Produk Terhapus' }}</td>
                                    <td class="text-center">{{ $detail->jumlah }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->subtotal ?? ($detail->harga_satuan * $detail->jumlah), 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-top pt-2 bg-light p-2 rounded">
                        <div class="row mb-1">
                            <div class="col-6 fw-bold">Total Belanja</div>
                            <div class="col-6 text-end fw-bold text-pink">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">Bayar ({{ $transaksi->metode_pembayaran }})</div>
                            <div class="col-6 text-end">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</div>
                        </div>
                        <div class="row small text-muted">
                            <div class="col-6">Kembalian</div>
                            <div class="col-6 text-end">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    {{-- Tombol Cetak Struk --}}
                    {{-- Menggunakan route 'transaksi.cetakStruk' sesuai file routes/web.php --}}
                    <a href="{{ route('transaksi.cetakStruk', $transaksi->kode_transaksi) }}" target="_blank" class="btn btn-primary text-white" style="background-color: #ff69b4; border: none;">
                        <i class="bi bi-printer me-1"></i> Cetak Struk
                    </a>
                </div>
            </div>
        </div>
    </div>

    @empty
      <div class="col-12">
          <div class="alert alert-info text-center py-4">
              <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
              Belum ada riwayat transaksi pada periode ini.
          </div>
      </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $transaksis->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection