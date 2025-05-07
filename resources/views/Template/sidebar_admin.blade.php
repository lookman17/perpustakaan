<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-footer" style="color: #007bff !important;font-size:17px;">Menu</div>
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
                <a class="nav-link" href="{{ route('donatur') }}">
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
            
        </div>     <img src="{{ asset('img/people.png') }}" alt="..." class="img-logo">

        <div class="sb-sidenav-footer"style="color: #007bff !important">
            <div class="small">Logged in as: {{ $user->user_nama }}</div>
            Admin Perpustakaan 
        </div>
    </nav>
</div>
<style>
    /* Sidebar Menu Styling */
/* Sidebar Menu Styling */
.sb-sidenav-menu .nav-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    color: #bbb; /* Menetapkan warna default teks */
    transition: background-color 0.3s, color 0.3s;
}

/* Hover Effects */
.sb-sidenav-menu .nav-link:hover {
    background-color: #007bff; /* Warna latar belakang saat hover */
    color: white !important; /* Mengubah warna teks menjadi putih dengan prioritas tinggi */
}

/* Ikon menu */
.sb-nav-link-icon {
    margin-right: 10px;
}

/* Menu Heading */
.sb-sidenav-menu-heading {
    font-size: 1.2rem;
    font-weight: bold;
    color: #ddd;
    padding: 15px 0;
}

/* Footer Styling */
.sb-sidenav-footer {
    font-size: 0.85rem;
    color: #bbb;
    padding: 10px 20px;
    background-color: #343a40;
    text-align: center;
}

/* Active link styles */
.sb-sidenav-menu .nav-link.active {
    background-color: #28a745;
    color: white;
}

/* Responsive: Collapse Menu for Small Screens */
@media (max-width: 768px) {
    .sb-sidenav {
        width: 100%;
        height: auto;
    }

    .sb-sidenav-menu {
        padding-top: 10px;
    }
}

</style>

{{--<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Navigasi Utama</div>

                <a class="nav-link {{ request()->routeIs('dashboardAdmin') ? 'active' : '' }}" href="{{ route('dashboardAdmin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt fa-fw"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Master Data</div>

                <a class="nav-link {{ request()->routeIs('buku') || request()->is('admin/buku*') ? 'active' : '' }}" href="{{ route('buku') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book fa-fw"></i></div>
                    Buku
                </a>
                <a class="nav-link {{ request()->routeIs('kategoriBuku') || request()->is('admin/kategori*') ? 'active' : '' }}" href="{{ route('kategoriBuku') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tags fa-fw"></i></div>
                    Kategori Buku
                </a>
                <a class="nav-link {{ request()->routeIs('rak.index') || request()->is('admin/rak*') ? 'active' : '' }}" href="{{ route('rak.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-layer-group fa-fw"></i></div>
                    Rak
                </a>
                <a class="nav-link {{ request()->routeIs('Penulis') || request()->is('admin/penulis*') ? 'active' : '' }}" href="{{ route('Penulis') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-feather-alt fa-fw"></i></div> 
                    Penulis
                </a>
                <a class="nav-link {{ request()->routeIs('Penerbit') || request()->is('admin/penerbit*') ? 'active' : '' }}" href="{{ route('Penerbit') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-building fa-fw"></i></div> 
                    Penerbit
                </a>

                <div class="sb-sidenav-menu-heading">Transaksi</div>

                <a class="nav-link {{ request()->routeIs('peminjaman') || request()->is('admin/peminjaman*') ? 'active' : '' }}" href="{{ route('peminjaman') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-heart fa-fw"></i></div> 
                    Peminjaman
                </a>

                <div class="sb-sidenav-menu-heading">Akun</div>

                <a class="nav-link {{ request()->routeIs('adminPengaturan') ? 'active' : '' }}" href="{{ route('adminPengaturan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-cog fa-fw"></i></div> 
                    Pengaturan
                </a>
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt fa-fw"></i></div>
                    Logout
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </div>

       
        <div class="sb-sidenav-footer">
            <div class="text-center mb-2">
                 <img src="{{ asset('img/people.png') }}" alt="Logo Aplikasi" class="img-fluid rounded-circle mb-1" style="max-width: 50px; border: 2px solid rgba(255,255,255,0.3);">
            </div>
            <div class="small">Masuk sebagai:</div>
            <span class="fw-medium">{{ $user->name ?? 'Nama Admin' }}</span>
        </div>

    </nav>
</div>

<style>
    /* Sidebar - Dark Theme Adjustments (Jika default sb-sidenav-dark kurang sesuai) */
    .sb-sidenav-dark {
        background-color: #2A3038; /* Sedikit lebih terang dari default */
        color: rgba(255, 255, 255, 0.7); /* Warna teks default sedikit lebih terang */
    }

    /* Menu Headings */
    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: rgba(255, 255, 255, 0.4); /* Warna heading lebih pudar */
        font-size: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding-top: 1.25rem; /* Beri jarak atas lebih */
    }

    /* Nav Links */
    .sb-sidenav-dark .sb-sidenav-menu .nav .nav-link {
        color: rgba(255, 255, 255, 0.7);
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
    }

    /* Nav Link Icons */
    .sb-sidenav-dark .sb-sidenav-menu .nav .nav-link .sb-nav-link-icon {
        color: rgba(255, 255, 255, 0.5); /* Warna ikon sedikit pudar */
        margin-right: 0.75rem; /* Sesuaikan jarak ikon */
        transition: color 0.15s ease-in-out;
    }

    /* Hover State */
    .sb-sidenav-dark .sb-sidenav-menu .nav .nav-link:hover {
        color: #ffffff; /* Teks putih terang saat hover */
        background-color: #007bff; /* Latar biru primer saat hover (sesuaikan jika perlu) */
    }
    .sb-sidenav-dark .sb-sidenav-menu .nav .nav-link:hover .sb-nav-link-icon {
        color: #ffffff; /* Ikon putih terang saat hover */
    }

    /* Active State */
    .sb-sidenav-dark .sb-sidenav-menu .nav .nav-link.active {
        color: #ffffff; /* Teks putih terang saat active */
        background-color: #0056b3; /* Warna biru lebih gelap untuk active (atau hijau #28a745 sesuai preferensi Anda) */
    }

    .sb-sidenav-dark .sb-sidenav-menu .nav .nav-link.active .sb-nav-link-icon {
        color: #ffffff; /* Ikon putih terang saat active */
    }

    /* Footer Sidebar */
    .sb-sidenav-dark .sb-sidenav-footer {
        background-color: rgba(0, 0, 0, 0.2); /* Background footer sedikit transparan */
        padding: 0.75rem 1rem;
        font-size: 0.8rem; /* Ukuran font kecil */
        text-align: center; /* Pusatkan teks di footer */
    }
     .sb-sidenav-dark .sb-sidenav-footer .small {
        color: rgba(255, 255, 255, 0.5); /* Warna teks "logged in as" */
     }
     .sb-sidenav-dark .sb-sidenav-footer .fw-medium {
        color: rgba(255, 255, 255, 0.8); /* Warna nama user lebih jelas */
     }

    /* Icon fixed width (PENTING untuk alignment) */
    .sb-nav-link-icon i.fa-fw {
       width: 1.28571429em; /* Default FontAwesome fixed width */
       text-align: center;
    }

</style>
--}}