@extends('layouts.app')

@section('title', 'Stok Produk')

@push('styles')
    <style>
        /* --- CSS BAWAAN (DIPERTAHANKAN SESUAI REQUEST) --- */
        /* Kita hapus body, html, sidebar, dan main-content margin
           karena sudah diatur oleh Master Layout (layouts.app) */

        /* Header & Judul */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #ff69b4;
            font-size: 28px;
            margin: 0;
            /* Reset margin bawaan browser */
        }

        /* Tombol Tambah (Style Asli) */
        .btn-tambah {
            padding: 12px 30px;
            background: #ff9cc7;
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            float: right;
        }

        .btn-container {
            margin-bottom: 20px;
            margin-top: 20px;
            position: flex;
            right: 50px;
        }

        .btn-tambah:hover {3
            background: #ff69b4;
            transform: translateY(-2px);
        }

        /* Search Box */
        .search-box {
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 12px 20px;
            border: 2px solid #ffc0cb;
            border-radius: 25px;
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: #ff69b4;
        }

        /* Tabel */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-x: auto;
            display: grid;
            grid-template-columns: 1fr;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        thead {
            background: #ff9cc7;
            color: white;
        }

        th,
        td {
            padding: 12px 16px;
            text-align: left;
            vertical-align: middle;
            white-space: nowrap;
        }

        td {
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:hover {
            background: #fff0f5;
        }

        td img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Status Stok */
        .stok-rendah {
            color: #ff4444;
            font-weight: bold;
        }

        .stok-normal {
            color: #4CAF50;
            font-weight: bold;
        }

        /* Tombol Aksi */
        .btn-aksi {
            padding: 6px 15px;
            margin: 0 3px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #4A90E2;
            color: white;
        }

        .btn-edit:hover {
            background: #357ABD;
        }

        .btn-hapus {
            background: #ff6b6b;
            color: white;
        }

        .btn-hapus:hover {
            background: #ff4444;
        }

        /* Modal Style (Asli) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h2 {
            color: #ff69b4;
            margin: 0;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 2px solid #ffc0cb;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ff69b4;
        }

        .modal-footer {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-batal,
        .btn-simpan {
            padding: 10px 25px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        .btn-batal {
            background: #ccc;
        }

        .btn-simpan {
            background: #ff9cc7;
        }

        .btn-simpan:hover {
            background: #ff69b4;
        }
    </style>
@endpush

@section('content')

    {{-- Konten Header --}}
    <div class="header">
        <h1>📦 Stok Barang</h1>
    </div>
    <div class="btn-container">
        <button class="btn-tambah" onclick="openCreateModal()">+ Tambah Barang</button>
    </div>
    {{-- Search --}}
    <div class="search-box">
        <input type="text" class="search-input" placeholder="Cari barang..." id="searchInput" onkeyup="searchTable()">
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="close()"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Oops! Ada yang salah:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="table-container">
        <table id="stokTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Ukuran</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($produks as $produk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $produk->path_gambar ? Storage::url($produk->path_gambar) : '/storage/produks/noImage.png' }}"
                                alt="{{ $produk->nama_produk }}">
                        </td>
                        <td>{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $produk->ukuran_baju ?? '-' }}</td>
                        <td>
                            <span class="{{ $produk->stok_produk <= 10 ? 'stok-rendah' : 'stok-normal' }}">
                                {{ $produk->stok_produk }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</td>
                        <td>
                            {{-- 
                                PERBAIKAN PENTING: 
                                Menggunakan @json($produk) agar data objek aman dibaca JS 
                            --}}
                            <button class="btn-aksi btn-edit"
                                onclick='openEditModal(@json($produk))'>Edit</button>

                            <form action="{{ route($routePrefix . '.produk.destroy', $produk) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Form --}}
    <div class="modal" id="myModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Barang Baru</h2>
            </div>

            <form id="formBarang" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="path_gambar">Gambar Barang</label>
                    <input type="file" id="path_gambar" name="path_gambar" accept="image/*">
                    <small style="font-size:11px; color:#888;">Kosongkan jika tidak ingin mengubah gambar (saat
                        edit).</small>
                </div>
                <div class="form-group">
                    <label for="nama_produk">Nama Barang</label>
                    <input type="text" id="nama_produk" name="nama_produk" required>
                </div>
                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <select id="id_kategori" name="id_kategori" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="ukuran_baju">Ukuran Baju (Opsional)</label>
                    <input type="text" id="ukuran_baju" name="ukuran_baju">
                </div>
                <div class="form-group">
                    <label for="stok_produk">Stok</label>
                    <input type="number" id="stok_produk" name="stok_produk" required>
                </div>
                <div class="form-group">
                    <label for="harga_produk">Harga</label>
                    <input type="number" id="harga_produk" name="harga_produk" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
                    <button type="submit" class="btn-simpan" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Variabel Modal
        const modal = document.getElementById('myModal');
        const modalTitle = document.getElementById('modalTitle');
        const formBarang = document.getElementById('formBarang');
        const formMethod = document.getElementById('formMethod');
        const btnSimpan = document.getElementById('btnSimpan');

        // Route dari Blade
        const storeUrl = "{{ route($routePrefix . '.produk.store') }}";
        const updateUrlBase = "{{ route($routePrefix . '.produk.index') }}";

        // --- FUNGSI GLOBAL WINDOW (Wajib agar onclick HTML terbaca) ---

        window.openCreateModal = function() {
            formBarang.reset();
            modalTitle.innerText = 'Tambah Barang Baru';
            formBarang.action = storeUrl;
            formMethod.value = 'POST';

            // Reset tombol
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';

            modal.style.display = 'block';
        }

        window.openEditModal = function(produk) {
            formBarang.reset();
            modalTitle.innerText = 'Edit Barang';
            formBarang.action = updateUrlBase + '/' + produk.id;
            formMethod.value = 'PUT';

            // Isi data ke form
            document.getElementById('nama_produk').value = produk.nama_produk;
            document.getElementById('id_kategori').value = produk.id_kategori;
            document.getElementById('ukuran_baju').value = produk.ukuran_baju;
            document.getElementById('stok_produk').value = produk.stok_produk;
            document.getElementById('harga_produk').value = produk.harga_produk;

            // Reset tombol
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';

            modal.style.display = 'block';
        }

        window.closeModal = function() {
            modal.style.display = 'none';
            formBarang.reset();
        }

        window.searchTable = function() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let tr = document.querySelectorAll('#tableBody tr');

            tr.forEach(row => {
                let tdNama = row.getElementsByTagName('td')[2];
                if (tdNama) {
                    let txtValue = tdNama.textContent || tdNama.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            });
        }

        // Event Listener Form Submit
        formBarang.addEventListener('submit', function() {
            btnSimpan.disabled = true;
            btnSimpan.innerText = 'Menyimpan...';
        });

        // Klik luar modal untuk menutup
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        // Auto Open Modal jika Error Validasi
        @if ($errors->any())
            openCreateModal();
        @endif
    </script>
@endpush
