<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Tabel Transaksi Penjualan 2021</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f5f5f5;
      margin-left: 250px;
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

    .container {
      max-width: 900px;
      margin: 0 auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .header-with-icon {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 15px;
    }

    h2 {
      color: #888;
      margin: 0;
      font-weight: normal;
    }

    .chart-icon-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 5px;
      transition: transform 0.2s;
    }

    .chart-icon-btn:hover {
      transform: scale(1.1);
    }

    .chart-icon-btn svg {
      width: 32px;
      height: 32px;
      fill: #ff9cc7;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
      border: 1px solid black;
    }

    th, td {
      border: 1px solid black;
      padding: 12px;
      text-align: left;
      vertical-align: middle;
    }

    th {
      background-color: #ff9cc7;
      color: #333;
      font-weight: bold;
    }

    tr:hover {
      background-color: #fafafa;
    }

    .date-col { width: 15%; }
    .name-col { width: 25%; }
    .amount-col { width: 35%; }
    .trans-col { width: 25%; }

    @media (max-width: 768px) {
      body {
        margin-left: 0;
      }
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <nav class="navbar mb-3">
      <a class="navbar-brand" href="#">Heny Daster</a>
    </nav>
    <ul class="nav flex-column" id="menu">
      <li class="nav-item"><a class="nav-link active" href="#">Katalog</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Stok Barang</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Riwayat Transaksi</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Laporan Keuangan</a></li>
      <li class="nav-item"><a class="nav-link" href="#">Data Akun</a></li>
    </ul>
  </div>

  <div class="container">
    <div class="header-with-icon">
      <h2>Maret 2021</h2>
      <button class="chart-icon-btn" onclick="alert('Tampilkan grafik Maret 2021')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M3 3v18h18M7 14l4-4 4 4 5-5"/>
        </svg>
      </button>
    </div>
    <table>
      <thead>
        <tr>
          <th class="date-col">Hari/Tgl</th>
          <th class="name-col">Nama Kasir</th>
          <th class="amount-col">Total Penjualan</th>
          <th class="trans-col">Jumlah Transaksi</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>10/10</td><td>Khasanah</td><td>Rp 5.630.000</td><td>198</td></tr>
        <tr><td>11/10</td><td>Michael</td><td>Rp 5.630.000</td><td>298</td></tr>
        <tr><td>12/10</td><td>Khasanah</td><td>Rp 5.630.000</td><td>398</td></tr>
        <tr><td>13/10</td><td>Monodya</td><td>Rp 5.630.000</td><td>168</td></tr>
        <tr><td>14/10</td><td>Monodya</td><td>Rp 5.630.000</td><td>108</td></tr>
      </tbody>
    </table>

    <div class="header-with-icon">
      <h2>April 2021</h2>
      <button class="chart-icon-btn" onclick="alert('Tampilkan grafik April 2021')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M3 3v18h18M7 14l4-4 4 4 5-5"/>
        </svg>
      </button>
    </div>
    <table>
      <thead>
        <tr>
          <th class="date-col">Hari/Tgl</th>
          <th class="name-col">Nama Kasir</th>
          <th class="amount-col">Total Penjualan</th>
          <th class="trans-col">Jumlah Transaksi</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>10/10</td><td>Khasanah</td><td>Rp 5.630.000</td><td>198</td></tr>
        <tr><td>11/10</td><td>Michael</td><td>Rp 5.630.000</td><td>298</td></tr>
        <tr><td>12/10</td><td>Khasanah</td><td>Rp 5.630.000</td><td>398</td></tr>
        <tr><td>13/10</td><td>Monodya</td><td>Rp 5.630.000</td><td>168</td></tr>
        <tr><td>14/10</td><td>Monodya</td><td>Rp 5.630.000</td><td>108</td></tr>
      </tbody>
    </table>

    <div class="header-with-icon">
      <h2>Mei 2021</h2>
      <button class="chart-icon-btn" onclick="alert('Tampilkan grafik Mei 2021')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M3 3v18h18M7 14l4-4 4 4 5-5"/>
        </svg>
      </button>
    </div>
    <table>
      <thead>
        <tr>
          <th class="date-col">Hari/Tgl</th>
          <th class="name-col">Nama Kasir</th>
          <th class="amount-col">Total Penjualan</th>
          <th class="trans-col">Jumlah Transaksi</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>10/10</td><td>Khasanah</td><td>Rp 5.630.000</td><td>198</td></tr>
        <tr><td>11/10</td><td>Michael</td><td>Rp 8.500.000</td><td>200</td></tr>
      </tbody>
    </table>
  </div>
</body>
</html>