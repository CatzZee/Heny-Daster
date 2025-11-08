<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>

    {{-- (MODIFIKASI) Menggunakan CSS Asli Kamu --}}
    <style>
        body,
        html {
            height: 100%;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            overflow: hidden;
            /* Mencegah body scroll */
        }

        /* Sidebar Kiri */
        .sidebar {
            background-color: #ff9cc7;
            height: 100vh;
            text-align: center;
            width: 230px;
            position: fixed;
            top: 0;
            left: 0;
        }

        .sidebar .navbar .navbar-brand {
            padding: 60px 20px;
            font-weight: bold;
            display: block;
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: bold;
            margin-bottom: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #ff69b4;
            border-radius: 15px;
            width: 100%;
        }

        /* Konten Tengah */
        .main-content {
            margin-left: 230px;
            margin-right: 270px;
            /* (MODIFIKASI) Pastikan ini cukup untuk sidebar kanan */
            padding: 20px;
            height: 100vh;
            /* (BARU) */
            overflow-y: auto;
            /* (BARU) Konten tengah bisa di-scroll */
        }

        /* Kategori scroll horizontal */
        .kategori-container {
            display: flex;
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px;
            scroll-behavior: smooth;
            border-radius: 10px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .kategori-container::-webkit-scrollbar {
            display: none;
        }

        .kategori-item {
            display: inline-block;
            padding: 40px 70px;
            margin: 0 8px;
            background-color: #ffffff;
            border: 3px solid #ffc0cb;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 20px;
            color: #ffc0cb;
            user-select: none;
        }

        .kategori-item:hover {
            background-color: #ffc0cb;
            color: white;
            border-color: #ffc0cb;
        }

        .kategori-item.active {
            background-color: #ff69b4;
            color: white;
            border-color: #ff69b4;
        }

        /* Grid Produk */
        .menu-baju {
            margin-left: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            /* (MODIFIKASI) Responsif */
            gap: 40px 20px;
            justify-items: center;
            margin-top: 20px;
        }

        .card-baju {
            position: relative;
            width: 150px;
            height: 180px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 10px;
            transition: transform 0.3s ease;
            overflow: visible;
            margin-bottom: 30px;
            cursor: pointer;
            /* (BARU) Menandakan bisa diklik */
        }

        .card-baju:hover {
            transform: translateY(-5px);
        }

        .card-baju img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 15px;
        }

        .harga {
            position: absolute;
            bottom: -5px;
            left: -8px;
            background-color: #ff9cc7;
            color: white;
            font-weight: bold;
            border-radius: 20px;
            padding: 6px 14px;
            font-size: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
            transform: scale(1.1);
            z-index: 10;
        }

        .nama-baju {
            position: absolute;
            bottom: -45px;
            left: 0;
            right: 0;
            font-weight: bold;
            color: #ff3b91;
            font-size: 16px;
            text-align: center;
        }

        /* Sidebar Kanan (Keranjang) */
        .offcanvas-end {
            background-color: #fff;
            border-left: 2px solid #ffc0cb;
            width: 270px;
            /* (MODIFIKASI) Sesuaikan dengan margin-right .main-content */
        }

        /* Tombol Logout */
        .sidebar-footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            padding: 0 20px;
        }

        .logout-button {
            display: block;
            width: 100%;
            padding: 12px 15px;
            background-color: #ff69b4;
            color: white;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #d9538f;
        }

        /* (BARU) Style untuk item di keranjang */
        .cart-item {
            font-size: 0.9rem;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
        }

        .cart-item-controls button {
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }

        .cart-item-controls .btn-remove {
            width: 25px;
            height: 25px;
            padding: 0;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <nav class="navbar mb-3">
            <a class="navbar-brand" href="#">Heny Daster</a>
        </nav>
        <ul class="nav flex-column" id="menu">
            <li class="nav-item">
                <a class="nav-link active" href="#">Katalog</a>
            </li>
            <li class="nav-item">
                {{-- (MODIFIKASI) Menggunakan $routePrefix dari controller --}}
                <a class="nav-link" href="{{ route($routePrefix . '.produk.index') }}">Stok Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Riwayat Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Laporan Keuangan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Data Akun</a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                @csrf
                <button type="submit" class="logout-button">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">

        <div class="kategori-container mb-4">
            <div class="kategori-item active" data-kategori-id="semua">Semua</div>
            @foreach ($kategoris as $kategori)
                <div class="kategori-item" data-kategori-id="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</div>
            @endforeach
        </div>

        <div class="menu-baju mt-4">

            {{-- (KEMBALIKAN) Loop $produks biasa --}}
            @forelse ($produks as $produk)
                {{-- (BARU) Sesuai idemu: buat nama tampilan dengan ukuran --}}
                @php
                    $nama_display = $produk->nama_produk;
                    if ($produk->ukuran_baju) {
                        $nama_display .= ' (' . $produk->ukuran_baju . ')';
                    }
                @endphp

                <div class="card-baju product-item" {{-- (KEMBALIKAN) class 'product-item' --}} data-kategori-id="{{ $produk->id_kategori }}"
                    data-id="{{ $produk->id }}" data-nama="{{ $nama_display }}" {{-- (PENTING) Data nama sekarang + ukuran --}}
                    data-harga="{{ $produk->harga_produk }}" data-stok="{{ $produk->stok_produk }}"
                    {{-- (HAPUS) data-bs-toggle dan data-bs-target dihapus --}}>

                    <img src="{{ $produk->path_gambar ? Storage::url($produk->path_gambar) : 'https://via.placeholder.com/200' }}"
                        alt="{{ $nama_display }}">

                    <div class="harga">{{ round($produk->harga_produk / 1000) }}K</div>

                    {{-- (PENTING) Tampilkan nama dengan ukuran --}}
                    <p class="nama-baju">{{ $nama_display }}</p>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: #ff3b91; padding: 50px;">
                    <h3>Oops!</h3>
                    <p>Belum ada produk yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="offcanvas offcanvas-end show" id="offcanvasNavbar" tabindex="-1" aria-labelledby="offcanvasNavbarLabel"
        style="visibility: visible; position: fixed;">
        <div class="offcanvas-header">
            <h4 style="color: #ffb3d9; font-weight: bold;">Keranjang</h4>
        </div>

        <div class="offcanvas-body">
            <div class="container-fluid">

                <div class="mb-3">
                    <label for="nama_pembeli" class="form-label" style="color: #ff3b91;">Nama Pembeli</label>
                    <input type="text" class="form-control" id="nama_pembeli" placeholder="Masukkan nama..." required
                        style="border-radius: 20px; border-color: #ffc0cb;">
                </div>

                <h6 class="text-secondary fw-bold">Items</h6>
                <div id="cart-items-list" style="max-height: 250px; overflow-y: auto; min-height: 50px;">
                    <p class="text-center text-muted" id="cart-empty-msg">Keranjang kosong</p>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <h5 style="color: #ff3b91;">Total</h5>
                    <h5 class="fw-bold" id="cart-total" style="color: #ff3b91;">Rp 0</h5>
                </div>

                <div class="mb-3 mt-2">
                    <label for="jumlah_bayar" class="form-label" style="color: #ff3b91;">Jumlah Bayar</label>
                    <input type="number" class="form-control" id="jumlah_bayar" placeholder="Rp 0"
                        style="border-radius: 20px; border-color: #ffc0cb;">
                </div>

                <div class="d-flex justify-content-between">
                    <p style="color: #ff3b91;">Kembalian</p>
                    <p class="fw-bold" id="kembalian" style="color: #ff3b91;">Rp 0</p>
                </div>

                <div style="position: absolute; bottom: 20px; left: 15px; right: 15px;">
                    <h5 style="color: #ffb3d9; font-weight: bold; margin-bottom: 15px;">Metode Pembayaran</h5>

                    {{-- Menggunakan radio button agar mudah diambil valuenya --}}
                    <div class="btn-group w-100 mb-3" role="group">
                        <input type="radio" class="btn-check" name="metode_pembayaran" id="metodeTunai"
                            value="Tunai" autocomplete="off" checked>
                        <label class="btn btn-outline-danger" for="metodeTunai"
                            style="border-color: #ffc0cb; color: #ff3b91;">Tunai</label>

                        <input type="radio" class="btn-check" name="metode_pembayaran" id="metodeQris"
                            value="Qris" autocomplete="off">
                        <label class="btn btn-outline-danger" for="metodeQris"
                            style="border-color: #ffc0cb; color: #ff3b91;">Qris</label>

                        <input type="radio" class="btn-check" name="metode_pembayaran" id="metodeTransfer"
                            value="Transfer" autocomplete="off">
                        <label class="btn btn-outline-danger" for="metodeTransfer"
                            style="border-color: #ffc0cb; color: #ff3b91;">Transfer</label>
                    </div>

                    <button id="btnProses"
                        style="width: 100%; padding: 15px; background-color: #ffb3d9; color: white; border: none; border-radius: 25px; font-weight: bold; font-size: 16px; cursor: pointer; transition: all 0.3s;">
                        Proses
                    </button>
                    <button id="btnBatal"
                        style="width: 100%; padding: 10px; background-color: transparent; color: #ff3b91; border: none; font-weight: bold; font-size: 14px; cursor: pointer; margin-top: 10px;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- (MODIFIKASI) JavaScript Fungsional Total --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // --- STATE APLIKASI ---
            let cart = []; // Keranjang belanja

            // --- AMBIL ELEMEN PENTING ---
            const cartItemsList = document.getElementById('cart-items-list');
            const cartEmptyMsg = document.getElementById('cart-empty-msg');
            const cartTotalEl = document.getElementById('cart-total');
            const btnProses = document.getElementById('btnProses');
            const btnBatal = document.getElementById('btnBatal');
            const namaPembeliEl = document.getElementById('nama_pembeli');
            const jumlahBayarEl = document.getElementById('jumlah_bayar');
            const kembalianEl = document.getElementById('kembalian');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const kategoriItems = document.querySelectorAll('.kategori-item');
            const productCards = document.querySelectorAll('.product-item');

            // --- FUNGSI ---

            // (BARU) Fungsi untuk Filter Kategori
            const filterKategori = (kategoriId) => {
                productCards.forEach(card => {
                    const cardKategoriId = card.getAttribute('data-kategori-id');

                    if (kategoriId === 'semua' || cardKategoriId === kategoriId) {
                        card.style.display = 'block'; // Tampilkan
                    } else {
                        card.style.display = 'none'; // Sembunyikan
                    }
                });
            };

            // Fungsi untuk menambah item ke keranjang
            const addItemToCart = (productData) => {
                const productId = productData.id;
                const productName = productData.nama;
                const productPrice = parseFloat(productData.harga);
                const productStok = parseInt(productData.stok);

                if (productStok <= 0) {
                    alert('Stok produk ' + productName + ' habis!');
                    return;
                }

                const existingItem = cart.find(item => item.id == productId);

                if (existingItem) {
                    if (existingItem.jumlah < productStok) {
                        existingItem.jumlah++;
                    } else {
                        alert('Stok produk ' + productName + ' tidak mencukupi!');
                    }
                } else {
                    cart.push({
                        id: productId,
                        nama: productName,
                        harga: productPrice,
                        jumlah: 1,
                        stok: productStok
                    });
                }
                renderCart();
            };

            // Fungsi untuk me-render tampilan keranjang
            const renderCart = () => {
                if (cart.length === 0) {
                    cartItemsList.innerHTML = '';
                    cartEmptyMsg.style.display = 'block';
                } else {
                    cartEmptyMsg.style.display = 'none';
                    cartItemsList.innerHTML = '';

                    cart.forEach(item => {
                        const itemHtml = `
                        <div class="d-flex justify-content-between align-items-center mb-2 cart-item">
                            <div>
                                <h6 class="mb-0">${item.nama}</h6>
                                <small class="text-muted">Rp ${formatRupiah(item.harga)}</small>
                            </div>
                            <div class="cart-item-controls">
                                <button class="btn btn-sm btn-outline-danger btn-qty-decrease" data-id="${item.id}">-</button>
                                <span class="mx-2">${item.jumlah}</span>
                                <button class="btn btn-sm btn-outline-danger btn-qty-increase" data-id="${item.id}">+</button>
                                <button class="btn btn-sm btn-danger ms-2 btn-remove-item" data-id="${item.id}">X</button>
                            </div>
                        </div>
                    `;
                        cartItemsList.innerHTML += itemHtml;
                    });
                }
                updateTotals();
            };

            // Fungsi untuk update total harga dan kembalian
            const updateTotals = () => {
                const totalHarga = cart.reduce((total, item) => total + (item.harga * item.jumlah), 0);
                cartTotalEl.innerText = `Rp ${formatRupiah(totalHarga)}`;

                const jumlahBayar = parseFloat(jumlahBayarEl.value) || 0;
                const kembalian = jumlahBayar - totalHarga;

                if (kembalian >= 0) {
                    kembalianEl.innerText = `Rp ${formatRupiah(kembalian)}`;
                } else {
                    kembalianEl.innerText = `-Rp ${formatRupiah(Math.abs(kembalian))}`;
                }
            };

            // Fungsi untuk memproses transaksi
            const processTransaction = async () => {
                const namaPembeli = namaPembeliEl.value;
                const metodePembayaran = document.querySelector('input[name="metode_pembayaran"]:checked')
                    .value;
                const totalHarga = cart.reduce((total, item) => total + (item.harga * item.jumlah), 0);
                const jumlahBayar = parseFloat(jumlahBayarEl.value) || 0;

                const items = cart.map(item => ({
                    produk_id: item.id,
                    jumlah: item.jumlah,
                    harga: item.harga
                }));

                if (cart.length === 0) {
                    alert('Keranjang masih kosong!');
                    return;
                }
                if (namaPembeli.trim() === '') {
                    alert('Nama Pembeli wajib diisi!');
                    namaPembeliEl.focus();
                    return;
                }
                if (jumlahBayar < totalHarga) {
                    alert('Jumlah bayar kurang dari total harga!');
                    jumlahBayarEl.focus();
                    return;
                }

                if (!confirm('Proses transaksi ini?')) {
                    return;
                }

                try {
                    // Menggunakan $routePrefix dari Blade
                    const response = await fetch("{{ route($routePrefix . '.transaksi.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            nama_pembeli: namaPembeli,
                            metode_pembayaran: metodePembayaran,
                            total_harga: totalHarga,
                            jumlah_bayar: jumlahBayar,
                            items: items
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        alert(result.success);
                        resetTransaksi();
                    } else {
                        if (response.status === 422) {
                            let errorMsg = 'Validasi Gagal:\n';
                            for (const key in result.errors) {
                                errorMsg += `${result.errors[key].join(', ')}\n`;
                            }
                            alert(errorMsg);
                        } else {
                            alert('Error: ' + (result.error || 'Terjadi kesalahan di server'));
                        }
                    }
                } catch (error) {
                    console.error('Fetch Error:', error);
                    alert('Tidak dapat terhubung ke server.');
                }
            };

            // Fungsi untuk mereset transaksi
            const resetTransaksi = () => {
                cart = [];
                namaPembeliEl.value = '';
                jumlahBayarEl.value = '';
                document.getElementById('metodeTunai').checked = true;
                renderCart();
                // Reload halaman untuk refresh stok produk
                window.location.reload();
            };

            // Fungsi untuk menangani aksi di keranjang
            const handleCartActions = (e) => {
                const target = e.target;
                const productId = target.closest('[data-id]').dataset.id;
                if (!productId) return;

                const itemIndex = cart.findIndex(item => item.id == productId);
                if (itemIndex === -1) return;

                const item = cart[itemIndex];

                if (target.classList.contains('btn-qty-increase')) {
                    if (item.jumlah < item.stok) {
                        item.jumlah++;
                    } else {
                        alert('Stok tidak mencukupi!');
                    }
                } else if (target.classList.contains('btn-qty-decrease')) {
                    item.jumlah--;
                    if (item.jumlah === 0) {
                        cart.splice(itemIndex, 1);
                    }
                } else if (target.classList.contains('btn-remove-item')) {
                    cart.splice(itemIndex, 1);
                }
                renderCart();
            };

            const formatRupiah = (angka) => {
                return new Intl.NumberFormat('id-ID').format(angka);
            };

            // --- EVENT LISTENERS ---

            // (BARU) Listener untuk Kategori
            kategoriItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Toggle active class
                    kategoriItems.forEach(i => i.classList.remove('active'));
                    item.classList.add('active');

                    // Filter
                    const filterId = item.getAttribute('data-kategori-id');
                    filterKategori(filterId);
                });
            });

            // Listener untuk klik produk
            document.querySelector('.menu-baju').addEventListener('click', (e) => {
                const productCard = e.target.closest('.product-item');
                if (productCard) {
                    addItemToCart(productCard.dataset);
                }
            });

            // Listener untuk aksi di keranjang
            cartItemsList.addEventListener('click', handleCartActions);

            // Listener untuk update kembalian
            jumlahBayarEl.addEventListener('input', updateTotals);

            // Listener tombol Proses
            btnProses.addEventListener('click', processTransaction);

            // Listener tombol Batal
            btnBatal.addEventListener('click', () => {
                if (confirm('Batalkan transaksi ini dan kosongkan keranjang?')) {
                    resetTransaksi();
                }
            });

        });
    </script>
</body>

</html>
