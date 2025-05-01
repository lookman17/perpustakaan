<nav class="sb-topnav navbar navbar-expand navbar-dark bg-primary shadow-sm">
    <!-- Sidebar toggle button -->
    <div class="d-flex align-items-center" style="gap: 10px;">
        <a class="navbar-brand ps-3" href="#">Welcome Siswa</a>
    </div>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-light" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Admin Dashboard dan Logo -->
    <div class="ms-auto d-flex align-items-center" style="gap: 10px; margin-right: 20px;">   
        <img 
            src="{{ asset('img/people.png') }}" 
            alt="Logo" 
            style="width: 30px; height: 30px;"
        >
        
        <a class="navbar-brand text-white mb-0" href="#">E-Learning-Book</a>
        <div>
            <a href="{{route('pengaturan')}}">
            @if ($user->user_pict_url === '')
            <img src="{{ asset('img/placeholder.png') }}" alt="Profil Default" class="rounded-circle img-profile img-thumbnail" style="width: 30px; height: 30px; margin-left: -5px;">
            @else
            <img src="{{ asset('storage/profile_pictures/'.basename($user->user_pict_url)) }}" alt="Profil Admin" class="rounded-circle img-profile" style="width: 30px; height: 30px; margin-left: -55px;">
            @endif 
            </a>
        </div>
    </div>

    <!-- Profil Pengguna -->
</nav>

<!-- CSS tambahan -->
<style>
    .img-logo {
        border-radius: 50%;
    }

    .navbar .ms-auto {
        margin-right: 20px;
    }
</style>
