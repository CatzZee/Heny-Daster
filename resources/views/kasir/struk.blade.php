<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Struk Transaksi</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
  :root {
    --accent-blue: #1ea7ff;
    --text-color: #111;
    --soft-pink: #f9a8d4;
  }

  html, body {
    height: 100%;
    margin: 0;
    background: #fff;
    font-family: "Poppins", sans-serif;
    color: var(--text-color);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px;
    box-sizing: border-box;
  }

  /* Sidebar */
  .sidebar {
    background-color:  #ff9cc7;
    width: 60px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    border-top-right-radius: 15px;
    border-bottom-right-radius: 15px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    gap: 15px;
  }

  .sidebar a {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 36px;
    height: 36px;
    border-radius: 8px;
    transition: background-color 0.2s;
  }

  .sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.3);
  }

  .sidebar svg {
    width: 22px;
    height: 22px;
    fill: white;
  }

  /* Container */
  .container {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 80px;
    flex-wrap: wrap;
    margin-left: 100px;
    width: 100%;
  }

  /* Struk */
  .receipt {
    width: 300px;
    border: 1px solid #000;
    padding: 20px 25px;
    box-sizing: border-box;
    background: #fff;
    text-align: left;
  }

  .receipt h2 {
    text-align: center;
    font-style: italic;
    margin: 0;
    font-weight: 600;
  }

  .receipt p.center {
    text-align: center;
    font-size: 13px;
    margin: 2px 0;
  }

  .dashed {
    border-top: 2px dotted #000;
    margin: 10px 0;
  }

  .row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin: 4px 0;
  }

  .item {
    font-size: 13px;
    margin: 8px 0;
  }

  .item small {
    font-size: 11px;
    display: block;
    margin-top: 2px;
  }

  .total-section {
    margin-top: 10px;
    font-size: 13px;
  }

  .total-section .row {
    margin: 3px 0;
  }

  .footer {
    margin-top: 12px;
    text-align: center;
    font-size: 12px;
    line-height: 1.5;
  }

  .footer strong {
    display: block;
  }

  /* Tombol Aksi */
  .actions {
    display: flex;
    flex-direction: column;
    gap: 40px;
    justify-content: flex-start;
    margin-top: 40px;
  }

  .btn {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 18px;
    color: var(--soft-pink);
    text-decoration: none;
    transition: 0.2s;
  }

  .btn svg {
    width: 36px;
    height: 36px;
    fill: var(--soft-pink);
  }

  .btn:hover {
    opacity: 0.7;
    cursor: pointer;
  }

  /* Responsif */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      align-items: center;
      margin-left: 0;
      gap: 40px;
    }
  }
</style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <a href="#">
    <!-- Icon Home -->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2h-4v-7H9v7H5a2 2 0 0 1-2-2z"/>
    </svg>
  </a>
</div>

<div class="container">

  <!-- Struk -->
  <div class="receipt">
    <h2>Heny Daster</h2>
    <p class="center">JL. Ikan Secret, No. 123</p>
    <p class="center">08912345678</p>

    <div class="dashed"></div>

    <div class="row">
      <span>Pelanggan : Anisa</span>
      <span>2021-03-9</span>
    </div>
    <div class="row">
      <span>Kasir : Dewi</span>
      <span>09.10</span>
    </div>
    <div class="row">
      <span></span>
      <span>No. 01</span>
    </div>

    <div class="dashed"></div>

    <div class="item">
      <div class="row">
        <span>Daster Pendek (xl)</span>
        <span>Rp. 30.000</span>
      </div>
      <small>1 x 30.000</small>
    </div>

    <div class="dashed"></div>

    <div class="total-section">
      <div class="row">
        <span>Total</span>
        <span>Rp. 30.000</span>
      </div>
      <div class="row">
        <span>Bayar</span>
        <span>Rp. 50.000</span>
      </div>
      <div class="row">
        <span>Kembali</span>
        <span>Rp. 20.000</span>
      </div>
    </div>

    <div class="footer">
      <strong>*Terimakasih telah berbelanja di Heny Daster*</strong>
      Kritik dan saran @HenyDasterShop
    </div>
  </div>

  <!-- Tombol Aksi -->
  <div class="actions">
    <a class="btn" href="#">
      <!-- Icon delete -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M9 3v1H4v2h16V4h-5V3H9zm1 5v10h2V8h-2zm4 0v10h2V8h-2zM5 8v10a2 2 0 002 2h10a2 2 0 002-2V8H5z"/>
      </svg>
      <span>Batalkan Transaksi</span>
    </a>

    <a class="btn" href="#" onclick="window.print()">
      <!-- Icon print -->
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M6 9V2h12v7h4v9h-4v5H6v-5H2V9h4zm2 0h8V4H8v5zm8 11v-3H8v3h8zm4-9H4v5h2v-2h12v2h2v-5z"/>
      </svg>
      <span>Cetak Struk</span>
    </a>
  </div>

</div>
</body>
</html>
