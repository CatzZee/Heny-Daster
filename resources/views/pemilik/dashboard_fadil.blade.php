<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilik Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                Pemilik Panel
            </a>
            
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">
                    Halo, <strong>{{ Auth::user()->nama ?? 'Pemilik' }}</strong>
                </span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="text-center p-5 bg-white rounded shadow-sm">
            <h1 class="display-4">Dashboard Pemilik</h1>
            <p class="lead">Anda berhasil login sebagai PEMILIK.</p>
            <p>Middleware role 'pemilik' bekerja!</p>
            <a href="#" class="btn btn-primary btn-lg mt-3">Lihat Laporan</a>
        </div>
    </main>

</body>
</html>