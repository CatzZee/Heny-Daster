@extends('layouts.app')

@section('title', 'Laporan Keuangan - Heny Daster')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Reset overflow dan scroll yang tidak diinginkan */
    body {
        overflow-x: hidden;
    }
    
    .container-fluid {
        padding: 20px;
        max-width: 100%;
        overflow-x: hidden;
    }

    /* Summary Cards Styling */
    .summary-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .summary-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .summary-card.income {
        background: linear-gradient(135deg, #ff69b4 0%, #ff9cc7 100%);
        color: white;
    }

    .summary-card.transactions {
        background: linear-gradient(135deg, #6a89cc 0%, #82ccdd 100%);
        color: white;
    }

    .summary-card.best-seller {
        background: linear-gradient(135deg, #4a69bd 0%, #60a3bc 100%);
        color: white;
    }

    .summary-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    .summary-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
        word-break: break-word;
    }

    .summary-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Modern Card Styling */
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        background: white;
        margin-bottom: 24px;
        padding: 24px;
        transition: transform 0.2s;
        overflow: hidden;
    }

    .modern-card:hover {
        transform: translateY(-2px);
    }

    /* Chart Container - PERBAIKAN PENTING */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        overflow: hidden;
    }
    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        overflow: hidden; /* Mencegah overflow */
    }

    .page-title {
        color: #444;
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 5px;
        word-break: break-word; /* Mencegah teks overflow */
    }

    .page-subtitle {
        color: #777;
        font-size: 1rem;
    }

    /* Filter Section */
    .filter-container {
        background: #fff;
        padding: 20px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 24px;
        overflow: hidden; /* Mencegah overflow */
    }

    .filter-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
    }

    .btn-pink {
        background-color: #ff69b4;
        color: white;
        border: none;
        padding: 8px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        white-space: nowrap; /* Mencegah tombol wrap */
    }

    .btn-pink:hover {
        background-color: #d9538f;
        color: white;
        transform: translateY(-2px);
    }

    /* Table Styling - Tanpa scroll horizontal */
    .table-container {
        border-radius: 16px;
        overflow: hidden; /* Hanya overflow untuk border radius */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        width: 100%;
    }

    .modern-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 0;
        table-layout: fixed; /* Mencegah tabel melebar */
    }

    .modern-table thead th {
        background-color: #ff9cc7;
        color: white;
        font-weight: 700;
        padding: 16px 20px;
        border: none;
        word-break: break-word; /* Mencegah teks overflow */
    }

    .modern-table tbody td {
        vertical-align: middle;
        padding: 16px 20px;
        border-bottom: 1px solid #f0f0f0;
        word-break: break-word; /* Mencegah teks overflow */
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .modern-table tbody tr:hover {
        background-color: #fef7fa;
    }

    /* Top Products Styling */
    .product-rank {
        width: 28px;
        height: 28px;
        background-color: #ff9cc7;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        margin-right: 12px;
        font-weight: 700;
        flex-shrink: 0; /* Mencegah penyusutan */
    }

    .product-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #eee;
        width: 100%;
        overflow: hidden; /* Mencegah overflow */
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-info {
        display: flex;
        align-items: center;
        min-width: 0; /* Memungkinkan text truncate */
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        color: #444;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis; /* Elipsis untuk teks panjang */
        max-width: 100%;
    }

    .product-sales {
        background-color: #f8f9fa;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        color: #555;
        white-space: nowrap; /* Mencegah wrap */
        flex-shrink: 0; /* Mencegah penyusutan */
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        overflow: hidden; /* Mencegah overflow chart */
    }

    /* Section Headers */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        overflow: hidden; /* Mencegah overflow */
    }

    .section-title {
        font-weight: 700;
        color: #444;
        margin-bottom: 0;
        word-break: break-word; /* Mencegah teks overflow */
    }

    .section-badge {
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        white-space: nowrap; /* Mencegah wrap */
    }

    /* Form elements - Mencegah overflow */
    .form-select {
        max-width: 100%;
        overflow: hidden;
    }

    /* Responsive Adjustments - Lebih ketat */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 15px;
        }
        
        .summary-card {
            margin-bottom: 15px;
            padding: 20px;
        }
        
        .summary-value {
            font-size: 1.5rem;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .section-badge {
            margin-top: 10px;
        }
        
        .modern-table {
            font-size: 0.9rem;
        }
        
        .modern-table thead th,
        .modern-table tbody td {
            padding: 12px 8px;
        }
        
        .filter-container .row {
            flex-direction: column;
        }
        
        .filter-container .col-md-4,
        .filter-container .col-md-8 {
            width: 100%;
            max-width: 100%;
        }
        
        .btn-pink {
            width: 100%;
            margin-top: 10px;
        }
    }

    @media (max-width: 576px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .summary-value {
            font-size: 1.3rem;
        }
        
        .modern-card {
            padding: 15px;
        }
        
        .product-name {
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
            <div>
                <h1 class="page-title">
                    <i class="bi bi-bar-chart-line-fill me-2" style="color: #ff69b4;"></i>
                    Laporan Penjualan
                </h1>
                <p class="page-subtitle">Rekapitulasi pendapatan dan performa produk Heny Daster</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <div class="row align-items-end">
            <div class="col-md-4 mb-3">
                <div class="filter-label">Periode Laporan</div>
                <form action="{{ route('pemilik.laporan') }}" method="GET" class="d-flex flex-column flex-md-row gap-2">
                    <div class="d-flex gap-2 flex-grow-1">
                        <select name="bulan" class="form-select">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>
                        <select name="tahun" class="form-select">
                            @foreach(range(date('Y')-2, date('Y')) as $y)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-pink mt-2 mt-md-0">
                        <i class="bi bi-funnel-fill me-1"></i> Terapkan
                    </button>
                </form>
            </div>
            <div class="col-md-8 d-flex justify-content-md-end">
                <div class="d-flex align-items-center">
                    <span class="badge bg-light text-dark fs-6">
                        <i class="bi bi-calendar-event me-1"></i>
                        {{ date('F Y', mktime(0, 0, 0, $bulan, 1)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="summary-card income">
                <div class="summary-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="summary-value">
                    Rp {{ number_format($laporanHarian->sum('total_pendapatan'), 0, ',', '.') }}
                </div>
                <div class="summary-label">
                    Total Pendapatan Bulan Ini
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card transactions">
                <div class="summary-icon">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="summary-value">
                    {{ $laporanHarian->sum('jumlah_transaksi') }}
                </div>
                <div class="summary-label">
                    Total Transaksi
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card best-seller">
                <div class="summary-icon">
                    <i class="bi bi-trophy"></i>
                </div>
                <div class="summary-value">
                    @if($topProduk->count() > 0)
                        {{ $topProduk->first()->nama_produk }}
                    @else
                        -
                    @endif
                </div>
                <div class="summary-label">
                    Produk Terlaris
                    @if($topProduk->count() > 0)
                        ({{ $topProduk->first()->total_terjual }} pcs)
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Top Products -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="modern-card">
                <div class="section-header">
                    <h5 class="section-title">Grafik Pendapatan Harian</h5>
                    <span class="section-badge">{{ date('F Y', mktime(0, 0, 0, $bulan, 1)) }}</span>
                </div>
                <div class="chart-container">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="modern-card">
                <div class="section-header">
                    <h5 class="section-title">🔥 Top 5 Produk Terlaris</h5>
                </div>
                @if($topProduk->count() > 0)
                    <div>
                        @foreach($topProduk as $index => $produk)
                        <div class="product-item">
                            <div class="product-info">
                                <span class="product-rank">{{ $index + 1 }}</span>
                                <span class="product-name">{{ $produk->nama_produk }}</span>
                            </div>
                            <span class="product-sales">{{ $produk->total_terjual }} pcs</span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-box2 text-muted fs-1 opacity-25"></i>
                        <p class="text-muted mt-2 small">Belum ada data penjualan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Transaction Details Table -->
    <div class="modern-card">
        <div class="section-header">
            <h5 class="section-title">Rincian Transaksi Harian</h5>
        </div>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="30%">Tanggal</th>
                            <th width="25%">Jumlah Transaksi</th>
                            <th class="text-end">Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporanHarian as $index => $data)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <i class="bi bi-calendar-event me-2 text-muted"></i>
                                {{ \Carbon\Carbon::parse($data->tanggal)->isoFormat('dddd, D MMMM Y') }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $data->jumlah_transaksi }} Transaksi
                                </span>
                            </td>
                            <td class="text-end fw-bold text-dark">Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($laporanHarian->count() > 0)
                    <tfoot style="background-color: #fafafa;">
                        <tr>
                            <td colspan="3" class="text-end fw-bold py-3">TOTAL PENDAPATAN BULAN INI:</td>
                            <td class="text-end fw-bold fs-5 py-3" style="color: #d63384;">
                                Rp {{ number_format($laporanHarian->sum('total_pendapatan'), 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// PERBAIKAN: Gunakan jQuery document ready atau window.onload untuk memastikan DOM siap
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM loaded - initializing chart");
    
    const ctx = document.getElementById('incomeChart');
    
    // Debug: Cek apakah canvas ditemukan
    if (!ctx) {
        console.error("Canvas element 'incomeChart' not found!");
        return;
    }
    
    // Debug: Cek data chart
    console.log("Chart Labels:", {!! json_encode($chartLabels) !!});
    console.log("Chart Data:", {!! json_encode($chartData) !!});
    
    // Pastikan data tidak kosong
    const chartLabels = {!! json_encode($chartLabels) !!} || [];
    const chartData = {!! json_encode($chartData) !!} || [];
    
    // Jika data kosong, tampilkan pesan
    if (chartLabels.length === 0 || chartData.length === 0) {
        ctx.getContext('2d').font = '16px Arial';
        ctx.getContext('2d').fillText('Tidak ada data untuk ditampilkan', 10, 50);
        console.warn("No chart data available");
        return;
    }
    
    // Gradient Fill untuk Grafik
    let gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(255, 105, 180, 0.5)');
    gradient.addColorStop(1, 'rgba(255, 255, 255, 0.0)');

    try {
        const incomeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: chartData,
                    borderColor: '#ff69b4',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#ff69b4',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#333',
                        bodyColor: '#666',
                        borderColor: '#eee',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return ' Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toLocaleString('id-ID') + 'k';
                            },
                            color: '#999',
                            font: { size: 11 }
                        },
                        border: { display: false }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#999',
                            font: { size: 11 }
                        },
                        border: { display: false }
                    }
                }
            }
        });
        
        console.log("Chart successfully initialized");
        
    } catch (error) {
        console.error("Error initializing chart:", error);
        // Fallback: Tampilkan pesan error di canvas
        ctx.getContext('2d').font = '14px Arial';
        ctx.getContext('2d').fillText('Error loading chart: ' + error.message, 10, 50);
    }
});
</script>
@endpush