<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-footer" style="color: #007bff !important;font-size:17px;">Menu</div>
                <!-- Dashboard -->
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <!-- Buku -->
                <a class="nav-link" href="{{ route('siswa.buku') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                    Buku
                </a>
                <!-- Kategori Buku -->
                <a class="nav-link" href="{{ route('peminjaman.siswa') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand"></i></div>
                    Peminjaman
                </a>
                <!-- Rak -->
                <a class="nav-link" href="{{ route('pengaturan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-gear"></i></div>
                    Pengaturan
                </a>
                <!-- Penulis -->
                <a class="nav-link" href="{{ route('logout') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-right-from-bracket"></i></div>
                    Logout
                </a>
            </div>
            
        </div>     <img src="{{ asset('img/people.png') }}" alt="..." class="img-logo">

        <div class="sb-sidenav-footer"style="color: #007bff !important">
            <div class="small">Logged in as: {{ $user->user_nama }}</div>
            Siswa Perpustakaan 
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