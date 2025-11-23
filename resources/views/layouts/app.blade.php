<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Heny Daster')</title>

    <style>
        /* --- CSS GLOBAL (Sidebar & Layout Dasar) --- */
        body, html { height: 100%; font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #fff; overflow: hidden; }
        
        /* Sidebar CSS (Copy semua CSS Sidebar & Toggle Button dari kode sebelumnya kesini) */
        .sidebar { background-color: #ff9cc7; height: 100vh; width: 230px; position: fixed; top: 0; left: 0; z-index: 100; transition: width 0.3s ease; display: flex; flex-direction: column; overflow: hidden; }
        body.sidebar-collapsed .sidebar { width: 80px; }
        
        .sidebar .navbar { padding: 0; min-height: 180px; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
        .brand-wrapper { display: flex; flex-direction: column; align-items: center; justify-content: center; width: 230px; transition: opacity 0.3s ease, visibility 0.3s; }
        .logo-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid white; margin-bottom: 15px; background-color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.15); }
        .brand-text { font-weight: bold; color: white; font-size: 1.25rem; text-decoration: none; display: block; text-align: center; letter-spacing: 0.5px; }
        body.sidebar-collapsed .brand-wrapper { opacity: 0; visibility: hidden; }
        
        .toggle-btn { position: absolute; top: 15px; right: 15px; background: none; border: none; color: white; font-size: 1.8rem; cursor: pointer; z-index: 102; transition: all 0.3s; }
        body.sidebar-collapsed .toggle-btn { right: 50%; transform: translateX(50%); }
        
        #menu { padding: 0 10px; margin-top: 10px; }
        .sidebar .nav-link { color: white; font-weight: bold; margin-bottom: 10px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; padding: 12px 20px; border-radius: 15px; white-space: nowrap; overflow: hidden; }
        .sidebar .nav-link i { font-size: 1.3rem; margin-right: 15px; min-width: 24px; text-align: center; transition: margin 0.3s; }
        body.sidebar-collapsed .sidebar .nav-link { justify-content: center; padding: 12px 0; width: 50px; margin: 0 auto 10px auto; }
        body.sidebar-collapsed .sidebar .nav-link i { margin-right: 0; font-size: 1.5rem; }
        body.sidebar-collapsed .sidebar .nav-link span { display: none; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: #ff69b4; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        
        .sidebar-footer { margin-top: auto; padding: 20px; width: 100%; }
        .logout-button { display: flex; justify-content: center; align-items: center; width: 100%; padding: 12px 0; background-color: #ff69b4; color: white; font-weight: bold; border-radius: 15px; transition: all 0.3s ease; border: none; cursor: pointer; overflow: hidden; }
        .logout-button span { margin-left: 10px; }
        .logout-button:hover { background-color: #d9538f; }
        body.sidebar-collapsed .sidebar-footer { padding: 10px; }
        body.sidebar-collapsed .logout-button { width: 50px; margin: 0 auto; padding: 12px 0; }
        body.sidebar-collapsed .logout-button span { display: none; }

        /* Main Content Wrapper */
        .main-content { margin-left: 230px; padding: 20px; height: 100vh; overflow-y: auto; transition: margin-left 0.3s ease; }
        body.sidebar-collapsed .main-content { margin-left: 80px; }

        /* Area untuk CSS tambahan dari view anak */
        @stack('styles')
    </style>
</head>

<body>

    {{-- Panggil File Sidebar --}}
    @include('partials.sidebar')

    {{-- Tempat Konten Halaman Berubah-ubah --}}
    <div class="main-content">
        @yield('content')
    </div>

    <script>
        // JS GLOBAL (Logic Sidebar Toggle)
        document.addEventListener('DOMContentLoaded', () => {
            const sidebarToggleBtn = document.getElementById('sidebarToggle');
            const body = document.body;
            
            // Cek LocalStorage
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                body.classList.add('sidebar-collapsed');
            }

            if(sidebarToggleBtn){
                sidebarToggleBtn.addEventListener('click', () => {
                    body.classList.toggle('sidebar-collapsed');
                    localStorage.setItem('sidebar-collapsed', body.classList.contains('sidebar-collapsed'));
                });
            }
        });
    </script>

    {{-- Area untuk JS tambahan dari view anak --}}
    @stack('scripts')
</body>
</html>