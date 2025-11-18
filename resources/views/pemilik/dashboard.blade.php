@extends('layouts.app')

@section('title', 'Kasir - Heny Daster')

@push('styles')
<style>
    /* --- 1. STRUKTUR POSISI MUTLAK (ANTI-TURUN) --- */

    /* Reset Container Utama dari app.blade.php */
    .main-content {
        padding: 0 !important;
        margin-right: 0 !important;
        width: 100%;
        height: 100vh;
        overflow: hidden !important; /* Matikan scroll body utama */
    }

    /* A. KERANJANG (DIPAKU DI KANAN) */
    .cart-fixed-sidebar {
        position: fixed;       /* KUNCI: Lepas dari aliran dokumen */
        top: 0;
        right: 0;
        bottom: 0;             /* Full tinggi dari atas ke bawah */
        width: 360px;          /* Lebar Tetap */
        background: #ffffff;
        z-index: 1050;         /* Pastikan di layer paling atas */
        border-left: 1px solid #e0e0e0;
        box-shadow: -5px 0 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
    }

    /* B. PRODUK (MENYESUAIKAN SISA RUANG) */
    .product-scroll-area {
        /* Memberi jarak kanan supaya tidak tertutup keranjang */
        margin-right: 360px !important; 
        
        height: 100vh;        /* Full Tinggi */
        overflow-y: auto;     /* Scrollbar sendiri */
        padding: 20px;
        background-color: #f4f6f9;
        transition: all 0.3s ease;
    }

    /* --- 2. DESAIN CARD (OLSERA STYLE) --- */
    .grid-produk {
        display: grid;
        /* Auto-fill: Isi kolom sebanyak mungkin, minimal lebar 160px */
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); 
        gap: 15px;
        padding-bottom: 100px; /* Jarak aman scroll bawah */
    }

    .card-pos {
        background: #fff; border-radius: 10px; border: 1px solid #eee;
        overflow: hidden; cursor: pointer; transition: transform 0.2s, border-color 0.2s;
        display: flex; flex-direction: column; height: 100%; position: relative;
    }
    .card-pos:hover { transform: translateY(-4px); border-color: #ffb3d9; box-shadow: 0 5px 15px rgba(255, 105, 180, 0.15); }
    
    .img-wrapper { height: 140px; width: 100%; background: #f9f9f9; position: relative; }
    .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .badge-stok { position: absolute; top: 6px; right: 6px; background: rgba(0,0,0,0.6); color: white; font-size: 10px; padding: 2px 8px; border-radius: 4px; backdrop-filter: blur(2px); font-weight: 600; }
    
    .info-wrapper { padding: 12px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .txt-nama { font-size: 13px; font-weight: 600; color: #333; line-height: 1.4; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .txt-harga { font-size: 14px; font-weight: 800; color: #ff3b91; }

    /* --- 3. KOMPONEN LAIN --- */
    /* Kategori */
    .cat-wrapper { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 5px; scrollbar-width: none; margin-bottom: 20px; }
    .cat-btn { padding: 8px 20px; background: white; border: 1px solid #ddd; border-radius: 20px; font-size: 13px; font-weight: 600; color: #666; cursor: pointer; white-space: nowrap; transition: all 0.2s; }
    .cat-btn:hover, .cat-btn.active { background: #ff3b91; color: white; border-color: #ff3b91; }

    /* Keranjang Styling */
    .cart-head { padding: 15px 20px; border-bottom: 1px solid #f0f0f0; background: white; flex-shrink: 0; }
    .cart-main { flex: 1; overflow-y: auto; padding: 15px 20px; background: white; }
    .cart-foot { padding: 20px; background: #fafafa; border-top: 1px solid #eee; flex-shrink: 0; }

    .list-item { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px dashed #eee; }
    .qty-box { display: flex; align-items: center; background: #f5f5f5; border-radius: 6px; padding: 2px; }
    .btn-pm { width: 22px; height: 22px; background: white; border: none; border-radius: 4px; font-size: 12px; cursor: pointer; color: #333; display: flex; align-items: center; justify-content: center; }
    .btn-pm:hover { background: #ff3b91; color: white; }
    .qty-num { width: 24px; text-align: center; font-size: 13px; font-weight: bold; }

    /* Scrollbar */
    .product-scroll-area::-webkit-scrollbar, .cart-main::-webkit-scrollbar { width: 6px; }
    .product-scroll-area::-webkit-scrollbar-thumb, .cart-main::-webkit-scrollbar-thumb { background: #ddd; border-radius: 10px; }
</style>
@endpush

@section('content')

    {{-- 1. AREA PRODUK (Fluid / Mengisi Sisa Ruang) --}}
    <div class="product-scroll-area">
        
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold m-0 text-dark">Katalog Produk</h5>
                <small class="text-muted">Pilih item untuk ditambahkan</small>
            </div>
            <div class="input-group input-group-sm w-auto" style="width: 220px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Cari produk..." style="box-shadow: none;">
            </div>
        </div>

        {{-- Kategori --}}
        <div class="cat-wrapper">
            <button class="cat-btn active" data-kategori-id="semua">Semua</button>
            @foreach ($kategoris as $kategori)
                <button class="cat-btn" data-kategori-id="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</button>
            @endforeach
        </div>

        {{-- Grid --}}
        <div class="grid-produk">
            @forelse ($produks as $produk)
                @php
                    $nama_display = $produk->nama_produk . ($produk->ukuran_baju ? ' (' . $produk->ukuran_baju . ')' : '');
                @endphp
                
                <div class="card-pos product-item" 
                     data-kategori-id="{{ $produk->id_kategori }}"
                     data-id="{{ $produk->id }}" 
                     data-nama="{{ $nama_display }}"
                     data-harga="{{ $produk->harga_produk }}" 
                     data-stok="{{ $produk->stok_produk }}">
                     
                     <div class="img-wrapper">
                         <img src="{{ $produk->path_gambar ? Storage::url($produk->path_gambar) : 'https://via.placeholder.com/200x200?text=Img' }}" loading="lazy">
                         <span class="badge-stok">Stok: {{ $produk->stok_produk }}</span>
                     </div>
                     <div class="info-wrapper">
                         <div class="txt-nama" title="{{ $nama_display }}">{{ $nama_display }}</div>
                         <div class="d-flex justify-content-between align-items-center">
                            <div class="txt-harga">{{ 'Rp ' . number_format($produk->harga_produk, 0, ',', '.') }}</div>
                            <i class="bi bi-plus-circle-fill text-danger fs-5 opacity-50"></i>
                         </div>
                     </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted" style="grid-column: 1/-1;">
                    <i class="bi bi-box2 fs-1 mb-2 d-block"></i> Produk Kosong
                </div>
            @endforelse
        </div>
    </div>


    {{-- 2. AREA KERANJANG (FIXED POSITION / DIPAKU) --}}
    <div class="cart-fixed-sidebar">
        
        {{-- Cart Header --}}
        <div class="cart-head d-flex justify-content-between align-items-center">
            <h6 class="fw-bold m-0 d-flex align-items-center gap-2">
                <i class="bi bi-cart4 text-danger fs-5"></i> Pesanan
            </h6>
            <span class="badge bg-danger rounded-pill" id="cart-count">0</span>
        </div>

        {{-- Cart Body --}}
        <div class="cart-main">
            <div class="mb-3">
                <input type="text" class="form-control form-control-sm" id="nama_pembeli" placeholder="Nama Pelanggan..." style="border-radius: 8px;">
            </div>
            
            <div id="cart-list">
                <div class="text-center py-5" id="empty-state">
                    <i class="bi bi-bag-x fs-1 text-secondary opacity-25 mb-2 d-block"></i>
                    <small class="text-muted">Keranjang kosong</small>
                </div>
            </div>
        </div>

        {{-- Cart Footer --}}
        <div class="cart-foot">
            <div class="d-flex justify-content-between mb-2 align-items-center">
                <small class="text-muted fw-bold">Total</small>
                <h5 class="fw-bold text-dark m-0" id="txt-total">Rp 0</h5>
            </div>
            
            <div class="input-group input-group-sm mb-3">
                <span class="input-group-text bg-white">Rp</span>
                <input type="number" class="form-control fw-bold" id="input-bayar" placeholder="0">
            </div>

            <div class="d-flex justify-content-between mb-3">
                <small class="text-muted">Kembali</small>
                <small class="fw-bold" id="txt-kembali">Rp 0</small>
            </div>

            <div class="row g-2 mb-3">
                <div class="col-6">
                    <input type="radio" class="btn-check" name="metode" id="tunai" value="Tunai" checked>
                    <label class="btn btn-outline-danger w-100 btn-sm" for="tunai">Tunai</label>
                </div>
                <div class="col-6">
                    <input type="radio" class="btn-check" name="metode" id="qris" value="Qris">
                    <label class="btn btn-outline-danger w-100 btn-sm" for="qris">QRIS</label>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button id="btn-bayar" class="btn btn-danger fw-bold shadow-sm py-2">BAYAR</button>
                <button id="btn-reset" class="btn btn-light btn-sm text-secondary">Reset</button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- VARIABEL & SETUP ---
        let cart = [];
        const cartListEl = document.getElementById('cart-list');
        const emptyStateEl = document.getElementById('empty-state');
        const totalEl = document.getElementById('txt-total');
        const kembaliEl = document.getElementById('txt-kembali');
        const inputBayar = document.getElementById('input-bayar');
        const inputNama = document.getElementById('nama_pembeli');
        const btnBayar = document.getElementById('btn-bayar');
        const cartCount = document.getElementById('cart-count');
        const productItems = document.querySelectorAll('.product-item');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const routeStore = "{{ route($routePrefix . '.transaksi.store') }}";

        const fmtRp = (n) => new Intl.NumberFormat('id-ID').format(n);

        // --- RENDER UI ---
        const render = () => {
            if(cart.length === 0) {
                cartListEl.innerHTML = ''; emptyStateEl.style.display = 'block'; cartCount.innerText = '0';
            } else {
                emptyStateEl.style.display = 'none'; cartListEl.innerHTML = ''; cartCount.innerText = cart.length;
                cart.forEach(item => {
                    cartListEl.innerHTML += `
                    <div class="list-item">
                        <div style="flex:1; padding-right:10px;">
                            <div style="font-weight:600; font-size:13px; color:#333; margin-bottom:2px;">${item.nama}</div>
                            <div style="font-size:11px; color:#888;">Rp ${fmtRp(item.harga)} x ${item.jumlah}</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="qty-box me-2">
                                <button class="btn-pm btn-dec" data-id="${item.id}">-</button>
                                <div class="qty-num">${item.jumlah}</div>
                                <button class="btn-pm btn-inc" data-id="${item.id}">+</button>
                            </div>
                            <button class="btn btn-link text-danger p-0 btn-del" data-id="${item.id}"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>`;
                });
            }
            calc();
        };

        const calc = () => {
            const total = cart.reduce((sum, i) => sum + (i.harga * i.jumlah), 0);
            const bayar = parseFloat(inputBayar.value) || 0;
            const kembali = bayar - total;
            totalEl.innerText = 'Rp ' + fmtRp(total);
            if(bayar > 0) {
                kembaliEl.innerText = kembali >= 0 ? 'Rp ' + fmtRp(kembali) : '-Rp ' + fmtRp(Math.abs(kembali));
                kembaliEl.className = kembali >= 0 ? 'fw-bold text-success' : 'fw-bold text-danger';
            } else {
                kembaliEl.innerText = 'Rp 0'; kembaliEl.className = 'fw-bold';
            }
        };

        const add = (dataset) => {
            const id = dataset.id; const stok = parseInt(dataset.stok);
            if(stok <= 0) return alert('Stok Habis!');
            const exist = cart.find(i => i.id == id);
            if(exist) { if(exist.jumlah < stok) exist.jumlah++; else return alert('Stok Maksimal!'); } 
            else { cart.push({ id: id, nama: dataset.nama, harga: parseFloat(dataset.harga), jumlah: 1, stok: stok }); }
            render();
        };

        // --- EVENT LISTENERS ---
        document.querySelector('.grid-produk').addEventListener('click', e => {
            const card = e.target.closest('.product-item'); if(card) add(card.dataset);
        });

        cartListEl.addEventListener('click', e => {
            const btn = e.target.closest('button'); if(!btn) return;
            const id = btn.getAttribute('data-id'); const idx = cart.findIndex(i => i.id == id);
            if(idx === -1) return;
            if(btn.classList.contains('btn-inc')) { if(cart[idx].jumlah < cart[idx].stok) cart[idx].jumlah++; else alert('Stok Maks'); }
            else if(btn.classList.contains('btn-dec')) { cart[idx].jumlah--; if(cart[idx].jumlah === 0) cart.splice(idx, 1); }
            else if(btn.classList.contains('btn-del')) { cart.splice(idx, 1); }
            render();
        });

        inputBayar.addEventListener('input', calc);
        document.querySelector('.cat-wrapper').addEventListener('click', e => {
            const btn = e.target.closest('.cat-btn'); if(!btn) return;
            document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active')); btn.classList.add('active');
            const kid = btn.getAttribute('data-kategori-id');
            productItems.forEach(item => { item.style.display = (kid === 'semua' || item.getAttribute('data-kategori-id') === kid) ? 'block' : 'none'; });
        });

        btnBayar.addEventListener('click', async () => {
            const nama = inputNama.value; const bayar = parseFloat(inputBayar.value) || 0;
            const total = cart.reduce((sum, i) => sum + (i.harga * i.jumlah), 0);
            if(cart.length === 0) return alert('Keranjang Kosong');
            if(!nama.trim()) { alert('Isi Nama Pelanggan'); return inputNama.focus(); }
            if(bayar < total) { alert('Pembayaran Kurang'); return inputBayar.focus(); }
            if(!confirm('Proses Transaksi?')) return;
            try {
                btnBayar.disabled = true; btnBayar.innerText = 'Loading...';
                const method = document.querySelector('input[name="metode"]:checked').value;
                const res = await fetch(routeStore, {
                    method: 'POST', headers: {'Content-Type':'application/json', 'X-CSRF-TOKEN':csrfToken, 'Accept':'application/json'},
                    body: JSON.stringify({ nama_pembeli: nama, metode_pembayaran: method, total_harga: total, jumlah_bayar: bayar, items: cart.map(i => ({produk_id: i.id, jumlah: i.jumlah, harga: i.harga})) })
                });
                const json = await res.json();
                if(res.ok) window.location.href = `/cetak-struk/${json.kode_transaksi}`;
                else { alert(json.message || 'Gagal'); btnBayar.disabled = false; btnBayar.innerText = 'BAYAR'; }
            } catch(e) { alert('Error Sistem'); btnBayar.disabled = false; btnBayar.innerText = 'BAYAR'; }
        });

        document.getElementById('btn-reset').addEventListener('click', () => { if(confirm('Reset Semua?')) location.reload(); });
    });
</script>
@endpush