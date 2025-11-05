<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body, html {
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

    .search-box { margin-bottom: 20px; }

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
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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

    th, td {
      padding: 12px 16px;
      text-align: left;
      vertical-align: middle;
      white-space: nowrap;
    }

    td {
      border-bottom: 1px solid #f0f0f0;
    }

    tbody tr:hover { background: #fff0f5; }

    .stok-rendah { color: #ff4444; font-weight: bold; }
    .stok-normal { color: #4CAF50; font-weight: bold; }

    .btn-aksi {
      padding: 6px 15px;
      margin: 0 3px;
      border: none;
      border-radius: 15px;
      cursor: pointer;
      font-size: 12px;
      transition: all 0.3s;
    }

    .btn-edit { background: #4A90E2; color: white; }
    .btn-edit:hover { background: #357ABD; }
    .btn-hapus { background: #ff6b6b; color: white; }
    .btn-hapus:hover { background: #ff4444; }

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
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
    }

    .modal-content {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 30px;
      border-radius: 15px;
      max-width: 500px;
      width: 90%;
    }

    .modal-header { margin-bottom: 20px; }
    .modal-header h2 { color: #ff69b4; }

    .form-group { margin-bottom: 15px; }
    .form-group label {
      display: block;
      margin-bottom: 5px;
      color: #666;
      font-weight: bold;
    }

    .form-group input, .form-group select {
      width: 100%;
      padding: 10px;
      border: 2px solid #ffc0cb;
      border-radius: 8px;
      font-size: 14px;
    }

    .form-group input:focus, .form-group select:focus {
      outline: none;
      border-color: #ff69b4;
    }

    .modal-footer {
      display: flex;
      gap: 10px;
      justify-content: flex-end;
      margin-top: 20px;
    }

    .btn-batal, .btn-simpan {
      padding: 10px 25px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      color: white;
    }

    .btn-batal { background: #ccc; }
    .btn-simpan { background: #ff9cc7; }
    .btn-simpan:hover { background: #ff69b4; }

    @media (max-width: 768px) {
      .main-content { margin-left: 0; padding: 20px; }
      .sidebar { display: none; }
      table { min-width: 500px; }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="navbar mb-3">
      <a class="navbar-brand" href="#">Heny Daster</a>
    </nav>
    <ul class="nav flex-column" id="menu">
      <li class="nav-item"><a class="nav-link active" href="#">Riwayat Transaksi</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Data Akun</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Stok Barang</a></li>
    </ul>
  </div>

  <!-- Konten Utama -->
  <div class="main-content">
    <div class="header">
      <h1>📦 Stok Barang</h1>
      <button class="btn-tambah" onclick="openModal()">+ Tambah Barang</button>
    </div>

    <div class="search-box">
      <input type="text" class="search-input" placeholder="🔍 Cari barang..." id="searchInput" onkeyup="searchTable()">
    </div>

    <div class="table-container">
      <table id="stokTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <tr>
            <td>1</td>
            <td><img src="https://via.placeholder.com/60" alt="Daster Pendek"></td>
            <td>Daster Pendek</td>
            <td>Daster</td>
            <td><span class="stok-normal">50</span></td>
            <td>Rp 90.000</td>
            <td>
              <button class="btn-aksi btn-edit" onclick="editBarang(1)">Edit</button>
              <button class="btn-aksi btn-hapus" onclick="hapusBarang(1)">Hapus</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td><img src="https://via.placeholder.com/60" alt="Daster Panjang"></td>
            <td>Daster Panjang</td>
            <td>Daster</td>
            <td><span class="stok-normal">30</span></td>
            <td>Rp 100.000</td>
            <td>
              <button class="btn-aksi btn-edit" onclick="editBarang(2)">Edit</button>
              <button class="btn-aksi btn-hapus" onclick="hapusBarang(2)">Hapus</button>
            </td>
          </tr>
          <tr>
            <td>3</td>
            <td><img src="https://via.placeholder.com/60" alt="Babydoll"></td>
            <td>Babydoll</td>
            <td>Pakaian Tidur</td>
            <td><span class="stok-rendah">5</span></td>
            <td>Rp 85.000</td>
            <td>
              <button class="btn-aksi btn-edit" onclick="editBarang(3)">Edit</button>
              <button class="btn-aksi btn-hapus" onclick="hapusBarang(3)">Hapus</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal" id="myModal">
    <div class="modal-content">
      <div class="modal-header"><h2>Tambah Barang Baru</h2></div>
      <form id="formBarang">
        <div class="form-group">
          <label>Gambar Barang</label>
          <input type="file" id="gambarBarang" accept="image/*">
        </div>
        <div class="form-group">
          <label>Nama Barang</label>
          <input type="text" id="namaBarang" required>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select id="kategori" required>
            <option value="">Pilih Kategori</option>
            <option value="Daster">Daster</option>
            <option value="Pakaian Tidur">Pakaian Tidur</option>
            <option value="Kemeja">Kemeja</option>
          </select>
        </div>
        <div class="form-group">
          <label>Stok</label>
          <input type="number" id="stok" required>
        </div>
        <div class="form-group">
          <label>Harga</label>
          <input type="number" id="harga" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-batal" onclick="closeModal()">Batal</button>
          <button type="submit" class="btn-simpan">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
      document.getElementById('myModal').style.display = 'none';
      document.getElementById('formBarang').reset();
    }

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

    function editBarang(id) {
      alert('Edit barang ID: ' + id);
      openModal();
    }

    function hapusBarang(id) {
      if (confirm('Yakin ingin menghapus barang ini?')) {
        alert('Barang ID ' + id + ' dihapus');
      }
    }

    document.getElementById('formBarang').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Barang berhasil ditambahkan!');
      closeModal();
    });

    window.onclick = function(event) {
      let modal = document.getElementById('myModal');
      if (event.target == modal) {
        closeModal();
      }
    }
  </script>
</body>
</html>
