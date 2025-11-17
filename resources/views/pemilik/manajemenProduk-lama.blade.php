<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stok Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

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

        .main-content {
            margin-left: 250px;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #ff69b4;
            font-size: 28px;
        }

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
        }

        .btn-tambah:hover {
            background: #ff69b4;
            transform: translateY(-2px);
        }

        .search-box {
            margin-bottom: 20px;
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

        .stok-rendah {
            color: #ff4444;
            font-weight: bold;
        }

        .stok-normal {
            color: #4CAF50;
            font-weight: bold;
        }

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

        td img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Modal */
        .modal {
            display: none;
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

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .sidebar {
                display: none;
            }

            table {
                min-width: 500px;
            }
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sidebar Kiri -->
    <div class="sidebar">
        <nav class="navbar mb-3">
            <a class="navbar-brand" href="#">Heny Daster</a>
        </nav>
        <ul class="nav flex-column" id="menu">
            {{-- 
        [PERUBAHAN 1: Link Sidebar Dinamis]
        Link sekarang menggunakan 'route()' helper.
        Asumsi Anda punya rute bernama '...dashboard' dan '...produk.index'
      --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route($routePrefix . '.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route($routePrefix . '.produk.index') }}">Stok Barang</a>
            </li>
            {{-- Anda bisa tambahkan link lain dengan cara yang sama --}}
            <li class="nav-item">
                <a class="nav-link" href="#">Riwayat Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route($routePrefix . '.akun.index') }}">Data Akun</a>
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

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="header">
            <h1>📦 Stok Barang</h1>
            {{-- [PERUBAHAN 3: Tombol Tambah] Menggunakan openModal() tapi untuk 'create' --}}
            <button class="btn-tambah" onclick="openCreateModal()">+ Tambah Barang</button>
        </div>

        <div class="search-box">
            <input type="text" class="search-input" placeholder="Cari barang..." id="searchInput"
                onkeyup="searchTable()">
        </div>

        {{-- [PERUBAHAN 4: Tampilkan Pesan Sukses/Error] --}}

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- (BARU) TAMBAHKAN BLOK INI UNTUK MENANGKAP ERROR DARI CONTROLLER --}}
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


        <div class="table-container">
            <table id="stokTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Ukuran</th> {{-- Sesuai Migrasi Anda --}}
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- 
            [PERUBAHAN 5: Loop Tabel Dinamis]
            Kita gunakan @forelse untuk loop data $produks dari Controller.
            Data statis <tr> dihapus.
          --}}
                    @forelse ($produks as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{-- Gunakan 'Storage::url' untuk path yang benar --}}
                                <img src="{{ $produk->path_gambar ? Storage::url($produk->path_gambar) : 'https://via.placeholder.com/60' }}"
                                    alt="{{ $produk->nama_produk }}">
                            </td>
                            <td>{{ $produk->nama_produk }}</td>
                            {{-- 'kategori' didapat dari eager loading 'with('kategori')' --}}
                            <td>{{ $produk->kategori->nama_kategori }}</td>
                            <td>{{ $produk->ukuran_baju ?? '-' }}</td>
                            <td>
                                {{-- Logika untuk stok rendah --}}
                                <span class="{{ $produk->stok_produk <= 10 ? 'stok-rendah' : 'stok-normal' }}">
                                    {{ $produk->stok_produk }}
                                </span>
                            </td>
                            {{-- Format harga --}}
                            <td>Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</td>
                            <td>
                                {{-- 
                  [PERUBAHAN 6: Tombol Aksi Dinamis]
                  Kita panggil JS 'editBarang' dan kirim data $produk sebagai JSON
                --}}
                                <button class="btn-aksi btn-edit"
                                    onclick="openEditModal({{ $produk }})">Edit</button>

                                {{-- 
                  Tombol Hapus kita ubah jadi form asli agar aman.
                  Class-nya sama, jadi tampilan tidak berubah.
                --}}
                                <form action="{{ route($routePrefix . '.produk.destroy', $produk) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Anda yakin ingin menghapus barang ini?');">
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
    </div>

    <!-- Modal -->
    <div class="modal" id="myModal">
        <div class="modal-content">
            <div class="modal-header">
                {{-- Judul modal akan diubah oleh JS --}}
                <h2 id="modalTitle">Tambah Barang Baru</h2>
            </div>

            {{-- 
        [PERUBAHAN 7: Form Modal Dinamis]
        Form ini akan diubah oleh JS untuk 'create' atau 'update'.
        Kita tambahkan 'enctype' untuk file upload.
      --}}
            <form id="formBarang" method="POST" action="" enctype="multipart/form-data">
                @csrf
                {{-- Input method (PUT) akan ditambahkan oleh JS di sini --}}
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="path_gambar">Gambar Barang</label>
                    {{-- 'name' harus 'path_gambar' sesuai Controller/Request --}}
                    <input type="file" id="path_gambar" name="path_gambar" accept="image/*">
                    <small>Kosongkan jika tidak ingin mengubah gambar.</small>
                </div>
                <div class="form-group">
                    <label for="nama_produk">Nama Barang</label>
                    {{-- 'name' harus 'nama_produk' --}}
                    <input type="text" id="nama_produk" name="nama_produk" required>
                </div>
                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    {{-- 'name' harus 'id_kategori' --}}
                    <select id="id_kategori" name="id_kategori" required>
                        <option value="">Pilih Kategori</option>
                        {{-- 
              [PERUBAHAN 8: Dropdown Kategori Dinamis]
              Loop data $kategoris dari Controller.
            --}}
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

    {{-- 
    [PERUBAHAN 9: JavaScript Dinamis]
    Kita modifikasi total JS Anda agar bisa menangani 'create' vs 'edit'
    dan auto-open modal jika ada error validasi.
  --}}
    <script>
        // Dapatkan elemen-elemen penting
        const modal = document.getElementById('myModal');
        const modalTitle = document.getElementById('modalTitle');
        const formBarang = document.getElementById('formBarang');
        const formMethod = document.getElementById('formMethod');
        const btnSimpan = document.getElementById('btnSimpan'); // <-- TAMBAHKAN INI

        // URL dasar untuk form (Create)
        const storeUrl = "{{ route($routePrefix . '.produk.store') }}";
        // URL dasar untuk form (Update), kita tambahkan ID nanti
        const updateUrlBase = "{{ route($routePrefix . '.produk.index') }}";

        function closeModal() {
            modal.style.display = 'none';
            formBarang.reset();

            // <-- TAMBAHAN: Reset tombol saat modal ditutup
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';
        }

        // Fungsi BARU untuk modal 'Create'
        function openCreateModal() {
            formBarang.reset();
            modalTitle.innerText = 'Tambah Barang Baru';
            formBarang.action = storeUrl;
            formMethod.value = 'POST';

            // <-- TAMBAHAN: Pastikan tombol dalam keadaan siap
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';

            modal.style.display = 'block';
        }

        // Fungsi BARU untuk modal 'Edit'
        function openEditModal(produk) {
            formBarang.reset();
            modalTitle.innerText = 'Edit Barang';
            formBarang.action = updateUrlBase + '/' + produk.id;
            formMethod.value = 'PUT';

            // <-- TAMBAHAN: Pastikan tombol dalam keadaan siap
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';

            // Isi form dengan data produk
            document.getElementById('nama_produk').value = produk.nama_produk;
            document.getElementById('id_kategori').value = produk.id_kategori;
            document.getElementById('ukuran_baju').value = produk.ukuran_baju;
            document.getElementById('stok_produk').value = produk.stok_produk;
            document.getElementById('harga_produk').value = produk.harga_produk;

            modal.style.display = 'block';
        }

        // ... (Fungsi searchTable() Anda tetap sama) ...
        function searchTable() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('stokTable');
            let tr = table.getElementsByTagName('tr');
            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td');
                let found = false;
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        let txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                tr[i].style.display = found ? '' : 'none';
            }
        }


        // <-- TAMBAHAN BARU: Event listener untuk form submit
        // Kita dengarkan event 'submit' pada form, bukan 'click' pada tombol.
        // Ini lebih baik karena menangkap semua cara submit (termasuk tekan 'Enter')
        formBarang.addEventListener('submit', function() {
            // 1. Nonaktifkan tombol
            btnSimpan.disabled = true;

            // 2. Beri umpan balik (Opsional tapi bagus)
            btnSimpan.innerText = 'Menyimpan...';

            // Form akan melanjutkan proses submit-nya secara normal
            // Karena kita tidak menggunakan e.preventDefault()
        });


        // Klik di luar modal untuk menutup
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        {{-- 
      [PERUBAHAN 10: Auto-open modal jika validasi GAGAL]
      ... (Blok @if ($errors->any()) Anda di sini) ...
    --}}
        @if ($errors->any()) // ... (Kode Anda untuk auto-open modal) ... @endif
    </script>
</body>

</html>
