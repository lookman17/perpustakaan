@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Tentang Perpustakaan Web - Admin Perpustakaan')

@section('header')
    @include('template.navbar_siswa')
@endsection

@section('main')
    <div id="layoutSidenav">
        @include('template.sidebar_siswa')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-primary fw-bold ">Dashboard</h1>
                    <ol class="breadcrumb mb-4 bg-white shadow-sm p-3 rounded">
                        
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Home</a></li>
                        <li class="breadcrumb-item active">Tentang Perpustakaan Web</li>
                        <li class="breadcrumb-item active">Selamat Datang {{Auth::user()->user_nama}}</li>
                        <li>
                            <!-- Bagian tentang pembuat -->
                            <div class="mt-5 pt-4 border-top">
                                <h5 class="text-primary fw-semibold">Perpustakaan ini dibuat oleh:</h5>
                                <div class="d-flex align-items-start mt-3">
                                    <!-- Foto di kiri -->
                                    <div class="me-4">
                                        <img 
                                            src="{{ asset('img/lq-nf.jpg') }}" 
                                            alt="Creator" 
                                            class="" 
                                            style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;"
                                        >
                                    </div>
                            
                                    <!-- Teks di kanan -->
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bold">Luqman Hakim</h6>
                                        <p class="mb-0 text-secondary">
                                    
                                            Semangat untuk terus belajar dan berkembang menjadikan Luqman Hakim sosok pelajar yang inspiratif bagi teman-teman! 🚀
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ol>
                    
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body bg-light">
                                    <h3 class="text-primary fw-bold">Perpustakaan Web</h3>
                                    <p class="text-secondary">
                                        Perpustakaan web adalah platform digital yang digunakan untuk mengelola, menyimpan, dan menyediakan akses ke koleksi buku, artikel, atau sumber daya lainnya melalui internet. Perpustakaan ini memungkinkan pengguna untuk mencari dan meminjam buku secara online tanpa harus datang langsung ke perpustakaan fisik. Pengguna dapat mengaksesnya kapan saja dan di mana saja asalkan terhubung dengan internet.
                                    </p>
                                    
                                    <h4 class="text-primary fw-semibold">Kelebihan Perpustakaan Web</h4>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-light">
                                            <strong>Akses Mudah dan Cepat:</strong> Pengguna dapat mengakses koleksi buku atau artikel kapan saja dan di mana saja tanpa terbatas oleh jam operasional perpustakaan fisik.
                                        </li>
                                        <li class="list-group-item bg-light">
                                            <strong>Penghematan Ruang:</strong> Semua koleksi dapat disimpan secara digital, mengurangi kebutuhan akan ruang penyimpanan fisik yang besar.
                                        </li>
                                        <li class="list-group-item bg-light">
                                            <strong>Fleksibilitas:</strong> Pengguna dapat mencari koleksi dengan mudah menggunakan kata kunci atau kategori, serta meminjam buku tanpa harus mengantri atau datang ke lokasi.
                                        </li>
                                        <li class="list-group-item bg-light">
                                            <strong>Peningkatan Aksesibilitas:</strong> Perpustakaan web mendukung aksesibilitas bagi orang dengan disabilitas, seperti pengaturan teks untuk pembaca layar atau pilihan font yang dapat disesuaikan.
                                        </li>
                                        <li class="list-group-item bg-light">
                                            <strong>Efisiensi Pengelolaan:</strong> Perpustakaan web memungkinkan pengelolaan yang lebih efisien dan terorganisir dengan fitur pencarian, peminjaman buku, dan pelacakan yang otomatis.
                                        </li>
                                    </ul>

                                    <h4 class="text-primary fw-semibold">Kesimpulan</h4>
                                    <p class="text-secondary">
                                        Perpustakaan web memberikan kenyamanan, kemudahan, dan efisiensi dalam mengakses koleksi buku dan bahan bacaan lainnya. Dengan berbagai kelebihan yang dimilikinya, perpustakaan web menjadi solusi modern dalam meningkatkan akses ke sumber daya informasi di era digital ini.
                                    </p>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            @include('template.footer')
        </div>
    </div>
@endsection
