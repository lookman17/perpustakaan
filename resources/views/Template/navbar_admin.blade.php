<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary shadow-sm">

    <!-- Navbar Brand (Logo & Nama Aplikasi) -->
    <a class="navbar-brand ps-3 d-flex align-items-center" href="{{ url('/admin/dashboard') }}"> {{-- Ganti URL jika perlu --}}
        <img src="{{ asset('img/people.png') }}" alt="App Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
        <span class="fw-semibold">E-Learning-Book</span>
    </a>

    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-auto ms-2 ms-lg-0 text-white" id="sidebarToggle" href="#!">
        <i class="fas fa-bars fa-fw"></i> {{-- fa-fw untuk fixed width --}}
    </button>

    <!-- Navbar Items Kanan (User Menu) -->
    <ul class="navbar-nav ms-auto me-3 me-lg-4 align-items-center"> {{-- Gunakan me-3 me-lg-4 untuk padding kanan --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdownUser" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{-- Gambar Profil --}}
                @php
                    // Tentukan path gambar yang valid
                    $profilePicPath = '';
                    if ($user->user_pict_url) {
                        $basename = basename($user->user_pict_url);
                        // Cek apakah file benar-benar ada di storage publik
                        if (file_exists(public_path('storage/profile_pictures/'.$basename))) {
                             $profilePicPath = asset('storage/profile_pictures/'.$basename);
                        }
                    }
                    // Jika path tidak valid atau kosong, gunakan placeholder
                    if (!$profilePicPath) {
                         $profilePicPath = asset('img/placeholder.png');
                    }
                @endphp
                <img class="rounded-circle me-2 navbar-profile-pic" src="{{ $profilePicPath }}" alt="Profil">
                {{-- Nama User (Tampil di layar sm ke atas) --}}
                <span class="d-none d-sm-inline text-white fw-medium">{{ $user->name ?? 'Admin' }}</span>
            </a>
            {{-- Dropdown Menu --}}
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                <li><a class="dropdown-item" href="{{ route('adminPengaturan') }}"><i class="bi bi-gear-fill me-2"></i>Pengaturan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<!-- CSS Tambahan (Letakkan di file CSS utama Anda atau di <style> di layout) -->
<style>
    .navbar-profile-pic {
        width: 32px; /* Ukuran konsisten */
        height: 32px;
        object-fit: cover; /* Menjaga aspek rasio gambar */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Optional: border halus */
    }

    /* Sedikit penyesuaian padding dropdown jika perlu */
    .dropdown-menu {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    .dropdown-item {
        display: flex;
        align-items: center;
    }
    .dropdown-item i {
        width: 1.5em; /* Pastikan ikon sejajar */
    }
</style>