<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- (BARU) Link untuk font Poppins dan Ikon Bootstrap --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bs-primary-rgb: 255, 105, 180; /* (BARU) Mengubah warna utama Bootstrap */
            --bs-primary: #ff69b4;
        }

        body,
        html {
            height: 100%;
            font-family: 'Poppins', sans-serif; /* (MODIFIKASI) Font lebih modern */
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* (MODIFIKASI) Latar belakang konten */
        }

        /* === Sidebar Kiri (TIDAK DIUBAH) === */
        .sidebar {
            background-color: #ff9cc7;
            height: 100vh;
            text-align: center;
            width: 230px;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px; /* (MODIFIKASI) Sedikit padding */
        }

        .sidebar .navbar .navbar-brand {
            padding: 40px 20px;
            font-weight: bold;
            display: block;
            color: white;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: bold;
            margin: 0 10px 10px 10px; /* (MODIFIKASI) Rapi */
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #ff69b4;
            border-radius: 15px;
            width: calc(100% - 20px); /* (MODIFIKASI) Rapi */
        }
        /* === Akhir Sidebar === */


        /* === Konten Utama === */
        .main-content {
            margin-left: 230px;
            padding: 30px;
        }

        /* (MODIFIKASI) Menggunakan card Bootstrap */
        .card-table {
            padding: 30px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        h1 {
            color: #ff69b4;
            font-weight: 600; /* (MODIFIKASI) */
        }
        
        /* (MODIFIKASI) Tombol Tambah (menggunakan style Bootstrap) */
        .btn-tambah {
            padding: 10px 25px;
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

        /* (MODIFIKASI) Input search (menggunakan style Bootstrap) */
        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 10px 20px;
            border: 1px solid #dee2e6;
            border-radius: 25px;
            font-size: 14px;
        }

        .search-input:focus {
            outline: none;
            border-color: #ff9cc7;
            box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25);
        }

        /* (MODIFIKASI) Table Header Pink */
        table thead {
            background: #ff9cc7;
            color: white;
            border-color: #ff9cc7;
        }
        
        table th {
            font-weight: 500;
        }

        /* (BARU) Style untuk foto profil di tabel */
        .table-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffb6c1;
        }

        /* (BARU) Ganti warna primary Bootstrap */
        .btn-primary {
            background-color: #ff69b4;
            border-color: #ff69b4;
        }

        .btn-primary:hover {
            background-color: #e65f9a;
            border-color: #e65f9a;
        }
        
        /* (BARU) Style tombol Batal di modal */
        .btn-batal {
             background-color: #6c757d;
             color: white;
        }
    </style>
</head>

<body>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <div class="sidebar">
        <nav class="navbar mb-3">
            <a class="navbar-brand" href="#">Heny Daster</a>
        </nav>
        <ul class="nav flex-column" id="menu">
            <li class="nav-item">
                <a class="nav-link" href="{{ route($routePrefix . '.dashboard') }}">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route($routePrefix . '.produk.index') }}">Stok Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Riwayat Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route($routePrefix . '.akun.index') }}">Data Akun</a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link"
                        style="background:none; border:none; width:100%; text-align:center;">Logout</button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>👤 Data Akun</h1>
            {{-- (MODIFIKASI) Menggunakan data-bs-toggle Bootstrap --}}
            <button class="btn btn-tambah" data-bs-toggle="modal" data-bs-target="#akunModal" onclick="openCreateModal()">
                + Tambah Akun
            </button>
        </div>

        {{-- (MODIFIKASI) Notifikasi (sudah benar) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

        {{-- (MODIFIKASI) Card + Table --}}
        <div class="card card-table">
            <div class="card-body">
                <div class="search-box mb-3">
                    <input type="text" class="search-input form-control" placeholder="Cari akun (nama, role)..." id="searchInput"
                        onkeyup="searchTable()">
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="stokTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img class="table-avatar" {{-- (MODIFIKASI) Class baru --}}
                                             src="{{ $user->path_gambar ? Storage::url($user->path_gambar) : 'https://via.placeholder.com/60' }}"
                                             alt="{{ $user->nama }}">
                                    </td>
                                    <td>{{ $user->nama }}</td>
                                    <td>
                                        {{-- (MODIFIKASI) Badge untuk role --}}
                                        @if($user->role == 'admin')
                                            <span class="badge bg-primary">{{ $user->role }}</span>
                                        @elseif($user->role == 'pemilik')
                                            <span class="badge bg-success">{{ $user->role }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- (MODIFIKASI) Tombol Aksi Bootstrap + Ikon --}}
                                        <button class="btn btn-sm btn-info text-white" 
                                            data-bs-toggle="modal" data-bs-target="#akunModal"
                                            onclick="openEditModal({{ $user }})">
                                            <i class="bi bi-pencil-fill"></i> Edit
                                        </button>

                                        <form action="{{ route($routePrefix . '.akun.destroy', $user) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data akun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="akunModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <form id="formAkun" method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-header" style="background: #fff0f5; border-bottom-color: #ffc0cb;">
                        <h2 class="modal-title fs-5" id="modalTitle" style="color: #ff69b4;">Tambah Akun Baru</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="_method" id="formMethod" value="POST">

                        <div class="mb-3">
                            <label for="path_gambar" class="form-label">Foto Akun (Opsional)</label>
                            <input type="file" class="form-control" id="path_gambar" name="path_gambar" accept="image/*">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Akun</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="kasir">Kasir</option>
                                <option value="pemilik">Pemilik</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small id="passwordHelp" class="form-text text-muted">
                                Kosongkan jika tidak ingin mengubah password saat edit.
                            </small>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #fff0f5; border-top-color: #ffc0cb;">
                        <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- (MODIFIKASI) JavaScript untuk Modal Bootstrap --}}
    <script>
        // (BARU) Inisialisasi Modal Bootstrap
        const akunModalElement = document.getElementById('akunModal');
        const akunModal = new bootstrap.Modal(akunModalElement);

        // Elemen-elemen penting
        const modalTitle = document.getElementById('modalTitle');
        const formAkun = document.getElementById('formAkun');
        const formMethod = document.getElementById('formMethod');
        const btnSimpan = document.getElementById('btnSimpan');
        const passwordInput = document.getElementById('password');
        const passwordHelp = document.getElementById('passwordHelp');

        const storeUrl = "{{ route($routePrefix . '.akun.store') }}";
        const updateUrlBase = "{{ route($routePrefix . '.akun.index') }}";

        // (BARU) Hapus fungsi closeModal(), Bootstrap sudah handle
        // function closeModal() { ... }

        // Fungsi untuk modal 'Create'
        function openCreateModal() {
            formAkun.reset();
            modalTitle.innerText = 'Tambah Akun Baru';
            formAkun.action = storeUrl;
            formMethod.value = 'POST';
            passwordInput.required = true;
            passwordHelp.style.display = 'none';
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';
            
            // (MODIFIKASI) Kita tidak perlu memanggil akunModal.show()
            // karena tombol "Tambah Akun" sudah punya data-bs-toggle
        }

        // Fungsi untuk modal 'Edit'
        function openEditModal(user) {
            formAkun.reset();
            modalTitle.innerText = 'Edit Akun';
            formAkun.action = updateUrlBase + '/' + user.id;
            formMethod.value = 'PUT';
            passwordInput.required = false;
            passwordHelp.style.display = 'block';
            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';

            // Isi form
            document.getElementById('nama').value = user.nama;
            document.getElementById('role').value = user.role;
            
            // (MODIFIKASI) Kita panggil .show() di sini karena 
            // tombol di tabel tidak punya data-bs-toggle
            // ...atau kita bisa tambahkan. Untuk konsistensi, kita panggil di sini:
            // akunModal.show(); // -> Sebenarnya tidak perlu jika tombol edit punya data-bs-toggle
        }

        // Fungsi searchTable() (tidak berubah)
        function searchTable() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('stokTable');
            let tr = table.getElementsByTagName('tr');
            for (let i = 1; i < tr.length; i++) {
                let tdNama = tr[i].getElementsByTagName('td')[2];
                let tdRole = tr[i].getElementsByTagName('td')[3];
                if (tdNama || tdRole) {
                    let txtNama = tdNama.textContent || tdNama.innerText;
                    let txtRole = tdRole.textContent || tdRole.innerText;
                    if (txtNama.toLowerCase().indexOf(filter) > -1 || txtRole.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

        // Event listener untuk form submit (tidak berubah)
        formAkun.addEventListener('submit', function() {
            btnSimpan.disabled = true;
            btnSimpan.innerText = 'Menyimpan...';
        });

        // (HAPUS) window.onclick tidak perlu lagi

        // Auto-open modal jika validasi GAGAL
        @if ($errors->any())
            // (MODIFIKASI) Kita tunggu DOM siap, baru panggil modal
            document.addEventListener('DOMContentLoaded', (event) => {
                // Asumsi error hanya dari "Create" untuk simpelnya
                // Cek apakah ada ID lama (jika error edit)
                @if (session('error_user_id'))
                    // Logika untuk buka modal edit (lebih kompleks)
                @else
                    // Buka modal create
                    openCreateModal();
                    akunModal.show();
                @endif
            });
        @endif
    </script>
</body>
</html>