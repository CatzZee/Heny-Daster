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
    font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    color: var(--text-color);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px;
    box-sizing: border-box;
  }

  /* Sidebar (navbar kecil kiri pink) */
  .sidebar {
    background-color: #ff9cc7;
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
    background-color: transparent;
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

  /* Container utama */
  .container {
    display: flex;
    align-items: flex-start;
    gap: 40px;
    flex-wrap: wrap;
    margin-left: 100px; /* kasih jarak dari sidebar */
  }

  /* Tombol Aksi */
  .actions {
    display: flex;
    flex-direction: column;
    gap: 40px;
    justify-content: flex-start;
    margin-top: 60px;
  }

  .btn {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 700;
    font-size: 20px;
    color: var(--soft-pink);
    text-decoration: none;
    transition: 0.2s;
  }

  .btn svg {
    width: 40px;
    height: 40px;
    fill: var(--soft-pink);
  }

  .btn:hover {
    opacity: 0.7;
    cursor: pointer;
  }

  /* Struk */
  .receipt-wrap {
    width: 480px;
    max-width: 95%;
    box-sizing: border-box;
    position: relative;
    border: 2px solid #000;
    border-radius: 4px;
    padding: 28px 32px 36px;
    background: #fff;
  }

  .receipt-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
  }

  .check-ico {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: var(--accent-blue);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .check-ico svg {
    width: 48px;
    height: 48px;
    display: block;
  }

  .title {
    font-size: 28px;
    font-weight: 600;
    margin: 6px 0 0 0;
  }

  .top-info {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-top: 12px;
    margin-bottom: 12px;
  }

  .top-left {
    width: 48%;
    font-size: 16px;
    line-height: 1.6;
  }

  .top-right {
    width: 48%;
    text-align: right;
    font-size: 14px;
    line-height: 1.3;
    color: #222;
  }

  .top-right .ref {
    display: block;
    margin-top: 6px;
    letter-spacing: 1px;
    font-family: monospace;
    font-size: 14px;
  }

  .dashed {
    border-top: 2px dotted #000;
    margin: 12px 0;
  }

  .details { margin-top: 6px; margin-bottom: 8px; }
  .row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
    margin: 8px 0;
  }

  .col-left { width: 48%; font-size: 15px; }
  .col-right { width: 48%; text-align: right; font-size: 15px; }

  .mono { font-family: monospace; letter-spacing: 1px; }

  .notes { margin-top: 14px; margin-bottom: 8px; font-size: 15px; }

  .money {
    margin-top: 10px;
    border-top: 1px solid rgba(0,0,0,0.04);
    padding-top: 12px;
  }

  .money .row { font-size: 15px; }
  .money .label { font-weight: 500; }
  .money .amount { font-weight: 600; }

  .total {
    margin-top: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: 700;
  }

  /* Responsif */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      align-items: center;
      margin-left: 0;
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
  <div class="receipt-wrap" role="document" aria-label="Struk Transaksi">
    <div class="receipt-header">
      <div class="check-ico" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <circle cx="12" cy="12" r="12" fill="#1ea7ff" />
          <path d="M7 12.5l2.7 2.7L17.3 7" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <h1 class="title">Transaksi Berhasil</h1>
    </div>

    <div class="top-info">
      <div class="top-left">
        <div>Tanggal</div>
        <div style="height:4px"></div>
        <div>Nomor Referensi</div>
      </div>
      <div class="top-right">
        <div>2022-10-31&nbsp;&nbsp;09:33:02 WIB</div>
        <span class="ref mono">12345678891827</span>
      </div>
    </div>

    <div class="dashed" aria-hidden="true"></div>

    <div class="details" role="group" aria-label="Detail Transaksi">
      <div class="row">
        <div class="col-left">Sumber Dana</div>
        <div class="col-right">Anisa Nur Kamila</div>
      </div>
      <div class="row">
        <div class="col-left">Jenis Transaksi</div>
        <div class="col-right">Transfer Bank ojk</div>
      </div>
      <div class="row">
        <div class="col-left">Bank Tujuan</div>
        <div class="col-right">BANK OJK</div>
      </div>
      <div style="height:10px"></div>
      <div class="row">
        <div class="col-left">Nomor Tujuan</div>
        <div class="col-right mono">1234567891827</div>
      </div>
      <div class="row">
        <div class="col-left">Nama Tujuan</div>
        <div class="col-right">Heny</div>
      </div>
    </div>

    <div style="height:12px"></div>

    <div class="notes">
      <div>Catatan</div>
    </div>

    <div class="dashed" aria-hidden="true" style="margin-top:6px"></div>

    <div class="money">
      <div class="row">
        <div class="col-left label">Nominal</div>
        <div class="col-right amount">Rp. 120.000</div>
      </div>
      <div class="row">
        <div class="col-left label">Biaya Admin</div>
        <div class="col-right amount">Rp. 0</div>
      </div>
      <div class="total">
        <div>Total</div>
        <div>Rp. 120.000</div>
      </div>
    </div>
  </div>

  <div class="actions">
    <a class="btn" href="#">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M9 3v1H4v2h16V4h-5V3H9zm1 5v10h2V8h-2zm4 0v10h2V8h-2zM5 8v10a2 2 0 002 2h10a2 2 0 002-2V8H5z"/>
      </svg>
      <span>Batalkan Transaksi</span>
    </a>

    <a class="btn" href="#" onclick="window.print()">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M6 9V2h12v7h4v9h-4v5H6v-5H2V9h4zm2 0h8V4H8v5zm8 11v-3H8v3h8zm4-9H4v5h2v-2h12v2h2v-5z"/>
      </svg>
      <span>Cetak Struk</span>
    </a>
  </div>
</div>

</body>
</html>
