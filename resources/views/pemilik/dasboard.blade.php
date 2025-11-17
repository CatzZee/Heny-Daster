<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Dashboard</title>
  <style>
    body, html {
      height: 100%;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #fff;
    }

    /* Sidebar */
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

    /* Area kanan (konten utama + kategori) */
    .main-content {
      margin-left: 230px;
      margin-right: 270px;
      padding: 20px;
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
      background-color:  #ffb3d9;
      color: white;
      border-color:  #ffb3d9;
    }

    .kategori-item.active {
      background-color: #ff69b4;
      color: white;
      border-color: #ff69b4;
    }

    .menu-baju {
      margin-left: 20px;
      display: grid;
      grid-template-columns: repeat(4, 1fr);
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
      box-shadow: 0 3px 8px rgba(0,0,0,0.1);
      text-align: center;
      padding: 10px;
      transition: transform 0.3s ease;
      overflow: visible;
      margin-bottom: 30px;
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
      background-color: #ff69b4;
      color: white;
      font-weight: bold;
      border-radius: 20px;
      padding: 6px 14px;
      font-size: 15px;
      box-shadow: 0 3px 6px rgba(0,0,0,0.15);
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

    /* Sidebar kanan (keranjang) */
    .offcanvas-end {
      background-color: #fff;
      border-left: 2px solid #ffc0cb;
    }

    .offcanvas-title {
      color: #ff69b4;
      font-weight: bold;
    }

    ::placeholder {
      color: #ff9cc7 !important;
    }

    .metode-bayar:hover {
      background-color: #ffe6f2;
      transform: translateY(-2px);
    }
    
    .metode-bayar.active {
      background-color: #ffb3d9;
      color: white;
    }
    
    #btnProses:hover {
      background-color: #ff99c7;
      transform: translateY(-2px);
    }

    .pembayaran-container {
      display: flex;
      overflow-x: auto;
      white-space: nowrap;
      gap: 10px;
      padding: 10px 0;
      scroll-behavior: smooth;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }

    .pembayaran-container::-webkit-scrollbar {
      display: none;
    }

    .pembayaran-item {
      flex: 0 0 auto;
      padding: 10px 25px;
      background-color: #ffffff;
      border: 3px solid #ffb3d9;
      border-radius: 50px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 14px;
      color: #ffc0cb;
      user-select: none;
      font-weight: bold;
    }

    .pembayaran-item:hover {
      background-color:  #ffb3d9;
      color: white;
      border-color: #ffb3d9;
    }

    .pembayaran-item.active {
      background-color: #ff69b4;
      color: white;
      border-color: #ff69b4;
    }

    
  </style>
</head>
<body>
  <!-- Sidebar Kiri -->
  <div class="sidebar">
    <nav class="navbar mb-3">
      <a class="navbar-brand" href="#">Heny Daster</a>
    </nav>
     <ul class="nav flex-column" id="menu">
      <li class="nav-item">
        <a class="nav-link active" href="#">Katalog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Stok Barang</a>
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
  </div>

  <!-- Konten utama -->
  <div class="main-content">
    <!-- Kategori di samping sidebar -->
    <div class="kategori-container mb-4">
      <div class="kategori-item active">Semua</div>
      <div class="kategori-item">Favorit</div>
      <div class="kategori-item">Daster Pendek</div>
      <div class="kategori-item">Daster Panjang</div>
      <div class="kategori-item">Babydoll</div>
    </div>

    <!-- Kotak-kotak menu baju -->
    <div class="menu-baju mt-4">
      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Daster Pendek">
        <div class="harga">90K</div>
        <p class="nama-baju">Daster Pendek</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Daster Panjang">
        <div class="harga">100K</div>
        <p class="nama-baju">Daster Panjang</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Babydoll">
        <div class="harga">85K</div>
        <p class="nama-baju">Babydoll</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Santai">
        <div class="harga">95K</div>
        <p class="nama-baju">Kemeja Santai</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Daster Motif">
        <div class="harga">92K</div>
        <p class="nama-baju">Daster Motif</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Daster Bali">
        <div class="harga">88K</div>
        <p class="nama-baju">Daster Bali</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Babydoll Premium">
        <div class="harga">110K</div>
        <p class="nama-baju">Babydoll Premium</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Daster Jumbo">
        <div class="harga">105K</div>
        <p class="nama-baju">Daster Jumbo</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Daster Polos">
        <div class="harga">80K</div>
        <p class="nama-baju">Daster Polos</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>

      <div class="card-baju">
        <img src="https://via.placeholder.com/200x200" alt="Kemeja Tidur">
        <div class="harga">98K</div>
        <p class="nama-baju">Kemeja Tidur</p>
      </div>
    </div>
  </div>

  <!-- Sidebar Kanan (Keranjang) -->
  <div class="offcanvas offcanvas-end show" id="offcanvasNavbar" tabindex="-1" aria-labelledby="offcanvasNavbarLabel" style="visibility: visible; position: fixed; width: 250px;">
    <div class="offcanvas-header">
      <h4 style="color: #ff69b4; font-weight: bold;">Keranjang</h4>
    </div>
    
    <div class="offcanvas-body">
      <div class="container-fluid">
        <div class="row g-2 mb-3">
          <div class="col-6">
            <input class="form-control text-center" type="text" placeholder="Orderan" disabled style="color:#ff3b91; border-radius:20px;">
          </div>
          <div class="col-6">
            <input class="form-control" list="datalistOptions" placeholder=""  style=" border-radius:20px;">
            <datalist id="datalistOptions"></datalist>
          </div>
        </div>

        <!-- Area untuk item keranjang bisa ditambahkan di sini -->
        
        <!-- Bagian Pembayaran -->
        <div style="position: absolute; bottom: 20px; left: 15px; right: 15px;">
          <h5 style="color: #ff69b4; font-weight: bold; margin-bottom: 15px;">Pembayaran</h5>
          
          <div class="pembayaran-container mb-3">
            <div class="pembayaran-item active">Tunai</div>
            <div class="pembayaran-item">Qris</div>
            <div class="pembayaran-item">Transfer</div>
          </div>

          <button id="btnProses" style="width: 100%; padding: 15px; background-color: #ffb3d9; color: white; border: none; border-radius: 25px; font-weight: bold; font-size: 16px; cursor: pointer; transition: all 0.3s;">Proses</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // kategori
    const kategoriItems = document.querySelectorAll('.kategori-item');
    kategoriItems.forEach(item => {
      item.addEventListener('click', () => {
        kategoriItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
      });
    });

    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
      item.addEventListener('click', () => {
        navItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
      });
    });

    // Scroll horizontal kategori 
    const kategoriContainer = document.querySelector('.kategori-container');
    kategoriContainer.addEventListener('wheel', (evt) => {
      evt.preventDefault();
      kategoriContainer.scrollLeft += evt.deltaY;
    });

    // hover pembayaran
    const pembayaranItems = document.querySelectorAll('.pembayaran-item');
    let metodeSelected = 'Tunai'; // default
    
    pembayaranItems.forEach(item => {
      item.addEventListener('click', () => {
        pembayaranItems.forEach(i => i.classList.remove('active'));
        item.classList.add('active');
        metodeSelected = item.textContent;
      });
    });

    // Scroll horizontal pembayaran 
    const pembayaranContainer = document.querySelector('.pembayaran-container');
    pembayaranContainer.addEventListener('wheel', (evt) => {
      evt.preventDefault();
      pembayaranContainer.scrollLeft += evt.deltaY;
    });

    // Tombol proses
    document.getElementById('btnProses').addEventListener('click', () => {
      alert('Memproses pembayaran dengan metode: ' + metodeSelected);
    });
  </script>
</body>
</html>