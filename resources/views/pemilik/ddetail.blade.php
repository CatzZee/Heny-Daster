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
    background-color: #ffb6c1;
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


  /* Responsif */
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      align-items: center;
      margin-left: 0;
    }
  }
  
    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-top: -25px;
    }

    /* Foto profil */
    .profile-img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #ff69b4;
    }

    .admin-name {
      margin-top: -25px;
      font-size: 16px;
    }

    .admin-name strong {
      font-weight: bold;
    }

    /* Kotak tabel */
    .profile-box {
      position: relative;
      margin-top: -15px;
      border: 1px solid #000;
      border-collapse: collapse;
      width: 600px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      border: 1px solid #000;
      padding: 10px;
    }

    td.label {
      background-color: #f7b9d0;
      width: 35%;
      font-weight: bold;
    }

    /* Tombol edit */
    .edit-btn {
      position: absolute;
      top: -15px;
      right: -15px;
      background-color: #f7b9d0;
      border: none;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s;
    }

    .edit-btn:hover {
      background-color: #ff8bb6;
    }

    .edit-btn::before {
      content: '✏️';
      font-size: 16px;
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
    <!-- Foto & Nama -->
    <img src="#" alt="" class="profile-img">
    <p class="admin-name"><strong>Admin</strong> Rudi</p>

    <!-- Data tabel -->
    <div class="profile-box">
      <button class="edit-btn"></button>
      <table>
        <tr>
          <td class="label">Nama Lengkap</td>
          <td>Rudi Purwanto</td>
        </tr>
        <tr>
          <td class="label">Nama Panggil</td>
          <td>Rudi</td>
        </tr>
        <tr>
          <td class="label">Tempat, Tanggal Lahir</td>
          <td>Malang, 19 Oktober 1999</td>
        </tr>
        <tr>
          <td class="label">Alamat Tempat Tinggal</td>
          <td>Jl. Cepurungan kelurang, No. 90</td>
        </tr>
      </table>
    </div>
  </div>


</body>
</html>
