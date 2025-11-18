<div class="sidebar">
    <button class="toggle-btn" id="sidebarToggle">
        <i class="bi bi-list"></i>
    </button>

    <nav class="navbar">
        <div class="brand-wrapper">
            <img src="{{ Storage::url('logo/logoToko.jpg') }}" 
                 alt="Logo Heny Daster" 
                 class="logo-img">
            
            <a class="brand-text">Heny Daster</a>
        </div>
    </nav>
    
    <ul class="nav flex-column" id="menu">
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('*.dashboard') ? 'active' : '' }}" href="#">
                <i class="bi bi-bag-heart-fill"></i><span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            {{-- Contoh penggunaan routeIs untuk active state otomatis --}}
            <a class="nav-link {{ Request::routeIs('*.produk.*') ? 'active' : '' }}" href="{{ route($routePrefix . '.produk.index') }}">
                <i class="bi bi-box-seam-fill"></i><span>Stok Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-clock-history"></i><span>Riwayat</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('*.akun.*') ? 'active' : '' }}" href="{{ route($routePrefix . '.akun.index') }}">
                <i class="bi bi-person-circle"></i><span>Data Akun</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
            @csrf
            <button type="submit" class="logout-button" title="Logout">
                <i class="bi bi-box-arrow-left"></i><span>Logout</span>
            </button>
        </form>
    </div>
</div>