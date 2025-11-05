<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sederhana agar footer bisa di bawah */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                Admin Panel
            </a>
            
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Halo, <strong>{{ Auth::user()->nama ?? 'Admin' }}</strong>
                </span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <h1 class="mb-4">Selamat Datang di Dashboard Admin</h1>
        <p class="lead">Anda telah berhasil login sebagai admin. Dari sini Anda bisa mengelola seluruh sistem.</p>

        <hr class="my-4">

        <div class="row g-3">
            
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Manajemen User</h5>
                        <p class="card-text">Kelola data user (kasir, pemilik, dll).</p>
                        <a href="#" class="btn btn-primary">Lihat User</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Penjualan</h5>
                        <p class="card-text">Lihat semua laporan transaksi.</p>
                        <a href="#" class="btn btn-primary">Lihat Laporan</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pengaturan</h5>
                        <p class="card-text">Atur konfigurasi aplikasi.</p>
                        <a href="#" class="btn btn-secondary">Pengaturan</a>
                    </div>
                </div>
            </div>

        </div> </main>

    <footer class="text-center text-muted p-4 bg-white shadow-sm mt-auto">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} Aplikasi E-Commerce Anda. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>