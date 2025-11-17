<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #fff;
    }

    /* Sidebar kiri */
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
      margin-left: 230px;
      padding: 20px;
    }

    /* transaksi */
    .transaction-card {
      position: relative;
      background-color: transparent;
      border: 2px;
      border-radius: 12px;
      overflow: hidden;
      transition: 0.3s;
      border: 2px solid #ff69b4;
    }

    .transaction-card .card-body {
      background-color: #fff;
      border-radius: 12px;
      padding: 15px 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: 0.3s;
    }

    .transaction-card .icon-box {
      background-color: #ff9cc7;
      color: white;
      font-size: 22px;
      font-weight: bold;
      border-radius: 10px;
      padding: 10px 14px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .text-pink {
      color: #ff69b4;
    }

    /* Hover state */
    .transaction-card:hover .card-body {
      background-color: #ff69b4;
      color: white;
      transform: scale(1.02);
    }

    /* Sembunyikan isi saat hover */
    .transaction-card:hover .card-body > * {
      opacity: 0;
    }

    /* Ikon hapus muncul saat hover */
    .transaction-card .delete-overlay {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 28px;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .transaction-card:hover .delete-overlay {
      opacity: 1;
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
    <div class="card transaction-card mb-3">
      <div class="card-body d-flex justify-content-between align-items-center">
        <!-- Kiri -->
        <div class="d-flex align-items-center">
          <div class="icon-box me-3">$</div>
          <div>
            <strong>Transaksi Tunai Masuk</strong><br>
            <small>21 Maret 2021 &nbsp;&nbsp; 09:10</small>
          </div>
        </div>

        <!-- Kanan -->
        <div class="text-end text-pink fw-bold">
          + Rp. 200.000
        </div>
      </div>

      <!-- Hover Icon -->
      <div class="delete-overlay">X</div>
    </div>
  </div>
</body>
</html>
