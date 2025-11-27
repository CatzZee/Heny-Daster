@extends('layouts.app')

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
    }

    .transaction-card:hover .delete-overlay {
      opacity: 1;
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
    <h3 class="mb-4 text-pink fw-bold">Riwayat Transaksi</h3>

    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif

    @forelse($transaksis as $transaksi)
    <div class="card transaction-card mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <!-- Wrapper konten agar bisa di-hide saat hover -->
        <div class="d-flex justify-content-between align-items-center w-100 content-wrapper">
            <!-- Kiri -->
            <div class="d-flex align-items-center">
              <div class="icon-box me-3">$</div>
              <div>
                <strong>{{ $transaksi->nama_pembeli ?? $transaksi->kode_transaksi }}</strong><br>
                <small>{{ \Carbon\Carbon::parse($transaksi->waktu_transaksi)->translatedFormat('d F Y H:i') }}</small>
              </div>
            </div>
    
            <!-- Kanan -->
            <div class="text-end text-pink fw-bold">
              + Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </div>
        </div>
      </div>

      <!-- Hover Icon (Delete Form) -->
      <div class="delete-overlay">
        <form action="{{ route('pemilik.riwayat-transaksi.destroy', $transaksi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat transaksi ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete" title="Hapus Transaksi">X</button>
        </form>
      </div>
    </div>
    @empty
      <div class="alert alert-info text-center">
          Belum ada riwayat transaksi.
      </div>
    @endforelse

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $transaksis->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection