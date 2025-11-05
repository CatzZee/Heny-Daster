<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun - Heny Daster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            font-family: 'Poppins', sans-serif;
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
            padding: 40px;
            text-align: center;
        }

        /* === Tampilan Data Akun === */
        .owner {
            text-align: center;
            margin-bottom: 50px;
        }

        .owner img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 3px solid #ff9cc7;
        }

        .owner h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .team {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 50px;
            margin-bottom: 40px;
        }

        .member {
            text-align: center;
        }

        .member img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 6px;
            border: 2px solid #ffb6c1;
        }

        .member p {
            margin: 0;
            font-size: 15px;
            font-weight: 500;
        }

        .add-btn {
            background-color: #ff9cc7;
            border: none;
            border-radius: 50%;
            width: 55px;
            height: 55px;
            font-size: 28px;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        .add-btn:hover {
            background-color: #ff7fb3;
            transform: scale(1.1);
        }
                /* ... (CSS kamu yang sudah ada) ... */

        /* === CSS UNTUK LOGOUT === */

        /* Ini adalah wrapper/container untuk tombol logout.
  Kita pakai position: absolute agar dia "terkunci" di bagian bawah.
*/
        .sidebar-footer {
            position: absolute;
            /* Mengunci posisi relatif terhadap .sidebar */
            bottom: 20px;
            /* Beri jarak 20px dari bawah */
            left: 0;
            right: 0;
            padding: 0 20px;
            /* Samakan padding kiri-kanan dengan .navbar-brand */
        }

        /* Ini adalah style untuk tombol logoutnya.
  Dibuat agar mirip dengan tema pink kamu.
*/
        .logout-button {
            display: block;
            width: 100%;
            padding: 12px 15px;
            background-color: #ff69b4;
            /* Warna pink yang sama dengan nav active */
            color: white;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            /* Hilangkan garis bawah dari tag <a> */
            border-radius: 15px;
            /* Samakan dengan radius nav-link */
            transition: all 0.3s ease;
            border: none;
            /* Menghilangkan border default browser */
            cursor: pointer;
        }

        /* Efek hover agar lebih interaktif */
        .logout-button:hover {
            background-color: #d9538f;
            /* Warna pink sedikit lebih gelap */
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                <a class="nav-link" href="#">Riwayat Transaksi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">Data Akun</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Stok Barang</a>
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

    <!-- Konten utama -->
    <div class="main-content">
        <div class="owner">
            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Owner">
            <h3>OWNER</h3>
        </div>

        <div class="team">
            <div class="member">
                <img src="https://randomuser.me/api/portraits/men/35.jpg" alt="Admin Rudi">
                <p>Admin Rudi</p>
            </div>
            <div class="member">
                <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Admin Zahra">
                <p>Admin Zahra</p>
            </div>
            <div class="member">
                <img src="https://randomuser.me/api/portraits/men/36.jpg" alt="Kasir Rendi">
                <p>Kasir Rendi</p>
            </div>
            <div class="member">
                <img src="https://randomuser.me/api/portraits/women/46.jpg" alt="Kasir Naura">
                <p>Kasir Naura</p>
            </div>
        </div>

        <button class="add-btn">+</button>
    </div>
</body>

</html>
