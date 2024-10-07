<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="{{ route('dashboardAdmin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ route('buku') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Buku
                </a>
                <a class="nav-link" href="{{ route('kategoriBuku') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                    Kategori Buku
                </a>
                <a class="nav-link" href="{{ route('rak.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-bars"></i></div>
                    Rak
                </a>
                <a class="nav-link" href="{{ route('Penulis') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-pencil"></i></div>
                    Penulis
                </a>
                <a class="nav-link" href="{{ route('Penerbit') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-house"></i></div>
                    Penerbit
                </a>
                <a class="nav-link" href="{{ route('peminjaman') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand"></i></div>
                    Peminjaman
                </a>


                <a class="nav-link" href="{{ route('adminPengaturan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-gear"></i></div>
                    Pengaturan
                </a>
                <a class="nav-link" href="{{ route('logout') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-right-from-bracket"></i></div>
                    Logout
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Admin Perpustakaan
        </div>
    </nav>
</div>
