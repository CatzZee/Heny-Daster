@extends('layouts.app')

@section('title', 'Data Akun - Heny Daster')

@push('styles')
    <style>
        /* --- CSS INI SAMA PERSIS DENGAN HALAMAN PRODUK (KONSISTEN) --- */

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
            font-weight: 700;
        }

        /* Tombol Tambah Pink */
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

        .btn-tambah:hover {
            background: #ff69b4;
            transform: translateY(-2px);
        }

        /* Search Box */
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

        /* Avatar Bulat */
        td img.avatar {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ffd1dc;
        }

        /* Badge Role */
        .badge-role {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }

        .bg-admin {
            background: #4A90E2;
        }

        .bg-owner {
            background: #ff69b4;
        }

        .bg-cashier {
            background: #f0ad4e;
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
            color: white;
        }

        .btn-edit {
            background: #4A90E2;
        }

        .btn-edit:hover {
            background: #357ABD;
        }

        .btn-hapus {
            background: #ff6b6b;
        }

        .btn-hapus:hover {
            background: #ff4444;
        }

        /* --- CSS MODAL CUSTOM (Sama seperti Produk) --- */
        .custom-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
        }

        .custom-modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header h2 {
            color: #ff69b4;
            margin-bottom: 20px;
            font-size: 24px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: bold;
            font-size: 13px;
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

        .btn-batal {
            background: #ccc;
            padding: 10px 25px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        .btn-simpan {
            background: #ff9cc7;
            padding: 10px 25px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        .btn-simpan:hover {
            background: #ff69b4;
        }

        .text-muted-small {
            font-size: 11px;
            color: #999;
            margin-top: 4px;
            display: block;
        }
    </style>
@endpush

@section('content')

    {{-- Header --}}
    <div class="header">
        <h1>👤 Data Akun</h1>
    </div>
    <div class="btn-container">
        <button class="btn-tambah" onclick="openCreateModal()">+ Tambah Barang</button>
    </div>
    {{-- Search --}}
    <div class="search-box">
        <input type="text" class="search-input" placeholder="Cari nama akun atau role..." id="searchInput"
            onkeyup="searchTable()">
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Oops! Ada kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tabel --}}
    <div class="table-container">
        <table id="akunTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Akun</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $user->path_gambar ? Storage::url($user->path_gambar) : '/storage/produks/noImage.png  ' }}"
                                class="avatar" alt="Avatar">
                        </td>
                        <td>{{ $user->nama }}</td>
                        <td>
                            @if ($user->role == 'admin')
                                <span class="badge-role bg-admin">Admin</span>
                            @elseif($user->role == 'pemilik')
                                <span class="badge-role bg-owner">Pemilik</span>
                            @else
                                <span class="badge-role bg-cashier">Kasir</span>
                            @endif
                        </td>
                        <td>
                            {{-- Tombol Edit (Pakai JSON agar aman) --}}
                            <button class="btn-aksi btn-edit"{{ Auth::id() == $user->id ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}
                                onclick='openEditModal(@json($user))'>Edit</button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route($routePrefix . '.akun.destroy', $user) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Yakin hapus akun {{ $user->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-aksi btn-hapus"
                                    {{ Auth::id() == $user->id ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 30px; color: #888;">Belum ada data akun.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL CUSTOM --}}
    <div class="custom-modal" id="myModal">
        <div class="custom-modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Akun Baru</h2>
            </div>

            <form id="formAkun" method="POST" action="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="form-group">
                    <label for="path_gambar">Foto Profil (Opsional)</label>
                    <input type="file" id="path_gambar" name="path_gambar" accept="image/*">
                    <span class="text-muted-small">Kosongkan jika tidak ingin mengubah foto.</span>
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required>
                </div>

                <div class="form-group">
                    <label for="role">Role / Jabatan</label>
                    <select id="role" name="role" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                        <option value="pemilik">Pemilik</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <span class="text-muted-small" id="passwordHelp">Wajib diisi untuk akun baru.</span>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
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
        // Variabel Elemen
        const modal = document.getElementById('myModal');
        const modalTitle = document.getElementById('modalTitle');
        const formAkun = document.getElementById('formAkun');
        const formMethod = document.getElementById('formMethod');
        const btnSimpan = document.getElementById('btnSimpan');
        const passwordHelp = document.getElementById('passwordHelp');
        const passwordInput = document.getElementById('password');

        // Route dari Blade
        const storeUrl = "{{ route($routePrefix . '.akun.store') }}";
        const updateUrlBase = "{{ route($routePrefix . '.akun.index') }}";

        // 1. BUKA MODAL CREATE
        window.openCreateModal = function() {
            formAkun.reset();
            modalTitle.innerText = 'Tambah Akun Baru';
            formAkun.action = storeUrl;
            formMethod.value = 'POST';

            // Password wajib untuk create
            passwordInput.required = true;
            passwordHelp.innerText = "Wajib diisi untuk akun baru.";

            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';
            modal.style.display = 'block';
        }

        // 2. BUKA MODAL EDIT
        window.openEditModal = function(user) {
            formAkun.reset();
            modalTitle.innerText = 'Edit Data Akun';
            formAkun.action = updateUrlBase + '/' + user.id;
            formMethod.value = 'PUT';

            // Isi data
            document.getElementById('nama').value = user.nama;
            document.getElementById('role').value = user.role;

            // Password opsional saat edit
            passwordInput.required = false;
            passwordHelp.innerText = "Kosongkan jika tidak ingin mengubah password.";

            btnSimpan.disabled = false;
            btnSimpan.innerText = 'Simpan';
            modal.style.display = 'block';
        }

        // 3. TUTUP MODAL
        window.closeModal = function() {
            modal.style.display = 'none';
            formAkun.reset();
        }

        // 4. SEARCH TABLE
        window.searchTable = function() {
            let input = document.getElementById('searchInput');
            let filter = input.value.toLowerCase();
            let tr = document.querySelectorAll('#tableBody tr');

            tr.forEach(row => {
                let tdNama = row.getElementsByTagName('td')[2];
                let tdRole = row.getElementsByTagName('td')[3];
                if (tdNama || tdRole) {
                    let txtNama = tdNama.textContent || tdNama.innerText;
                    let txtRole = tdRole.textContent || tdRole.innerText;
                    if (txtNama.toLowerCase().indexOf(filter) > -1 || txtRole.toLowerCase().indexOf(filter) > -
                        1) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                }
            });
        }

        // 5. EVENT LISTENER
        // Klik luar modal
        window.onclick = function(event) {
            if (event.target == modal) closeModal();
        }

        // Submit Loading
        formAkun.addEventListener('submit', function() {
            btnSimpan.disabled = true;
            btnSimpan.innerText = 'Menyimpan...';
        });

        // Auto Open Error
        @if ($errors->any())
            openCreateModal();
        @endif
    </script>
@endpush
