<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Struk Transaksi {{ $transaksi->kode_transaksi }}</title> {{-- (DINAMIS) --}}

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --accent-blue: #1ea7ff;
            --text-color: #111;
            --soft-pink: #f9a8d4;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            background: #f4f7f6;
            /* (MODIFIKASI) Background sedikit abu */
            font-family: "Poppins", sans-serif;
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
            box-sizing: border-box;
        }

        /* Sidebar */
        .sidebar {
            background-color: #ffb6c1;
            width: 60px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            gap: 15px;
        }

        .sidebar a {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .sidebar svg {
            width: 22px;
            height: 22px;
            fill: white;
        }

        /* Container */
        .container {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 80px;
            flex-wrap: wrap;
            margin-left: 100px;
            width: 100%;
        }

        /* Struk */
        .receipt {
            width: 320px;
            /* (MODIFIKASI) Sedikit lebih lebar */
            border: 1px solid #000;
            padding: 20px 25px;
            box-sizing: border-box;
            background: #fff;
            text-align: left;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            /* (BARU) */
        }

        .receipt h2 {
            text-align: center;
            font-style: italic;
            margin: 0;
            font-weight: 600;
        }

        .receipt p.center {
            text-align: center;
            font-size: 13px;
            margin: 2px 0;
        }

        .dashed {
            border-top: 2px dotted #000;
            margin: 10px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin: 4px 0;
        }

        .item {
            font-size: 13px;
            margin: 8px 0;
        }

        .item small {
            font-size: 11px;
            display: block;
            margin-top: 2px;
        }

        .total-section {
            margin-top: 10px;
            font-size: 13px;
        }

        .total-section .row {
            margin: 3px 0;
        }

        .total-section .row.grand-total {
            /* (BARU) */
            font-weight: 700;
            font-size: 14px;
            margin-top: 5px;
        }

        .footer {
            margin-top: 12px;
            text-align: center;
            font-size: 12px;
            line-height: 1.5;
        }

        .footer strong {
            display: block;
        }

        /* Tombol Aksi */
        .actions {
            display: flex;
            flex-direction: column;
            gap: 40px;
            justify-content: flex-start;
            margin-top: 40px;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 18px;
            color: var(--soft-pink);
            text-decoration: none;
            transition: 0.2s;
        }

        .btn svg {
            width: 36px;
            height: 36px;
            fill: var(--soft-pink);
        }

        .btn:hover {
            opacity: 0.7;
            cursor: pointer;
        }

        /* Responsif */
        @media (max-width: 768px) {
            body {
                padding: 20px;
            }

            .container {
                flex-direction: column;
                align-items: center;
                margin-left: 0;
                gap: 40px;
            }

            .sidebar {
                display: none;
                /* Sembunyikan sidebar di HP */
            }
        }

        /* (BARU) CSS Khusus untuk Print */
        /* ... (CSS kamu yang lain) ... */

        /* (BARU) CSS Khusus untuk Print */
        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            /* 1. Sembunyikan semua yang tidak perlu */
            .sidebar,
            .actions {
                display: none !important;
            }

            /* 2. Atur ulang layout container */
            .container {
                display: block;
                width: 100%;
                margin: 0;
                padding: 0;
            }

            /* 3. Atur struk agar pas di kertas thermal (ini intinya) */
            .receipt {
                width: 280px;
                /* Lebar untuk kertas thermal 58mm */
                border: none;
                box-shadow: none;
                font-family: 'Courier New', Courier, monospace;
                /* Font khas struk */
                font-size: 10px;
                /* Font kecil */
                padding: 0;
                margin: 0;
            }

            /* 4. Atur ulang font dan margin internal */
            .receipt h2 {
                font-size: 16px;
            }

            .receipt p.center,
            .row,
            .item,
            .total-section {
                font-size: 10px;
            }

            .item small {
                font-size: 9px;
            }

            .total-section .row.grand-total {
                font-size: 11px;
            }

            .footer {
                font-size: 9px;
            }

            .dashed {
                border-top: 1px dashed #000;
            }
        }
    </style>
    </style>
</head>
{{-- (BARU) Tambahkan onload="window.print()" untuk auto-print --}}

<body onload="window.print()">

    <div class="sidebar">
        {{-- Gunakan Auth::user()->role untuk route dinamis --}}
        <a href="{{ route(Auth::user()->role . '.dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">

                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4v-7H9v7H5a2 2 0 0 1-2-2z" />

            </svg>
        </a>
    </div>

    <div class="container">

        <div class="receipt">
            <h2>Heny Daster</h2>
            <p class="center">Jln. MT Haryono Gang VlllD no.94</p>
            <p class="center">08912345678</p>

            <div class="dashed"></div>

            {{-- (DINAMIS) Menggunakan data $transaksi --}}
            <div class="row">
                <span>Pelanggan : {{ $transaksi->nama_pembeli }}</span>
                <span>{{ $transaksi->waktu_transaksi->format('d-m-Y') }}</span>
            </div>
            <div class="row">
                <span>Kasir : {{ $transaksi->pengguna->nama }}</span>
                <span>{{ $transaksi->waktu_transaksi->format('H.i') }}</span>
            </div>
            <div class="row">
                <span></span>
                <span>No. {{ $transaksi->kode_transaksi }}</span>
            </div>

            <div class="dashed"></div>

            {{-- (DINAMIS) Loop untuk items --}}
            @foreach ($transaksi->details as $item)
                <div class="item">
                    <div class="row">
                        <span>
                            {{ $item->produk->nama_produk }}
                            @if ($item->produk->ukuran_baju)
                                ({{ $item->produk->ukuran_baju }})
                            @endif
                        </span>
                        <span>Rp.
                            {{ number_format($item->harga_saat_transaksi * $item->jumlah, 0, ',', '.') }}</span>
                    </div>
                    <small>{{ $item->jumlah }} x
                        {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</small>
                </div>
            @endforeach

            <div class="dashed"></div>

            {{-- (DINAMIS) Total section --}}
            <div class="total-section">
                <div class="row grand-total">
                    <span>Total</span>
                    <span>Rp. {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="row">
                    <span>Bayar ({{ $transaksi->metode_pembayaran }})</span>
                    <span>Rp. {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="row">
                    <span>Kembali</span>
                    <span>Rp. {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="footer">
                <strong>*Terimakasih telah berbelanja di Heny Daster*</strong>
            </div>

        </div>

        <div class="actions">
            {{-- (DIHAPUS) Tombol "Batalkan Transaksi" dihapus karena tidak relevan --}}

            <a class="btn" href="#" onclick="window.print(); return false;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">

                    <path d="M6 9V2h12v7h4v9h-4v5H6v-5H2V9h4zm2 0h8V4H8v5zm8 11v-3H8v3h8zm4-9H4v5h2v-2h12v2h2v-5z" />

                </svg>
                <span>Cetak Ulang</span> {{-- (MODIFIKASI) Teks tombol --}}
            </a>
        </div>

    </div>
</body>

</html>
