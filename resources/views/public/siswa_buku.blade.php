@extends('template.layout')
@php
    // Sebaiknya ambil user di controller jika memungkinkan,
    // tapi jika hanya untuk display nama di navbar, ini oke.
    $user = Auth::user();
@endphp

@section('title', 'Daftar Buku - Siswa')

@section('styles') {{-- Atau tempat lain di layout Anda untuk CSS --}}
<style>
    .book-card-img {
        width: 100%;
        height: 250px; /* Sedikit dikurangi agar tidak terlalu dominan */
        object-fit: cover; /* Mempertahankan aspek rasio gambar */
        border-top-left-radius: var(--bs-card-inner-border-radius); /* Sesuaikan dengan radius card */
        border-top-right-radius: var(--bs-card-inner-border-radius);
    }
    /* Optional: Style for disabled input to make it clearer */
    input[type=number]:disabled {
        background-color: #e9ecef; /* Warna abu-abu standar Bootstrap */
        cursor: not-allowed;
    }
    .card-body .btn-detail {
      font-size: 0.85rem; /* Kecilkan sedikit tombol detail */
    }
</style>
@endsection

@section('header')
    @include('template.navbar_siswa')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_siswa')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Daftar Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Pilih buku yang ingin Anda pinjam</li>
                </ol>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                 @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <form action="{{ route('buku.pinjam.multiple') }}" method="POST">
                    @csrf
                    <div class="mb-4 text-end"> {{-- Pindahkan ke kanan agar lebih standar --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>Pinjam Buku Terpilih
                        </button>
                    </div>

                    {{-- Grid Responsif: 1 kolom di xs, 2 di sm, 3 di md, 4 di lg/xl --}}
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        @forelse ($bukus as $buku)
                            <div class="col">
                                {{-- Tambahkan shadow-sm untuk efek kedalaman --}}
                                <div class="card h-100 shadow-sm">
                                    <img src="{{ asset($buku->buku_gambar ?? 'storage/buku_pictures/default_book.png') }}" {{-- Pastikan ada default_book.png --}}
                                         alt="Cover {{ $buku->buku_judul }}"
                                         class="book-card-img" /> {{-- Ganti class --}}

                                    <div class="card-body d-flex flex-column"> {{-- Flex column agar tombol detail bisa di bawah --}}
                                        {{-- Judul dan Info Dasar --}}
                                        <h5 class="card-title fs-6 fw-bold mb-1">{{ Str::limit($buku->buku_judul, 50) }}</h5> {{-- Batasi panjang judul --}}
                                        <small class="text-muted mb-1">
                                            <i class="fas fa-user fa-fw me-1"></i> {{ $buku->penulis->penulis_nama_id ?? 'N/A' }}
                                        </small>
                                        <small class="text-muted mb-2">
                                            <i class="fas fa-tag fa-fw me-1"></i> {{ $buku->kategori->kategori_nama ?? 'N/A' }}
                                        </small>

                                        <div class="mt-auto"> {{-- Dorong elemen berikut ke bawah kartu --}}
                                             {{-- Input Jumlah & Stok --}}
                                            @if($buku->buku_stok > 0)
                                                <div class="input-group input-group-sm mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm">Jumlah</span>
                                                    <input type="number" name="buku_ids[{{ $buku->buku_id }}]"
                                                        id="buku{{ $buku->buku_id }}"
                                                        min="0"
                                                        max="{{ $buku->buku_stok }}"
                                                        class="form-control text-center"
                                                        value="0"
                                                        aria-label="Jumlah pinjam {{ $buku->buku_judul }}"
                                                        aria-describedby="inputGroup-sizing-sm">
                                                </div>
                                                <small class="text-success d-block text-center mb-2">
                                                    <i class="fas fa-check-circle fa-fw me-1"></i> Stok: {{ $buku->buku_stok }}
                                                </small>
                                            @else
                                                {{-- Nonaktifkan input jika stok 0 --}}
                                                <div class="input-group input-group-sm mb-2">
                                                    <span class="input-group-text" id="inputGroup-sizing-sm-disabled">Jumlah</span>
                                                     <input type="number"
                                                        class="form-control text-center"
                                                        value="0"
                                                        disabled
                                                        aria-label="Jumlah pinjam (Stok Habis)">
                                                </div>
                                                <span class="badge bg-danger d-block w-100 mb-2">
                                                    <i class="fas fa-times-circle fa-fw me-1"></i> Stok Habis
                                                </span>
                                            @endif

                                            {{-- Tombol Detail --}}
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm w-100 btn-detail"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetailBuku{{ $buku->buku_id }}">
                                                <i class="fas fa-eye me-1"></i> Lihat Detail
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail Buku -->
                            <div class="modal fade" id="modalDetailBuku{{ $buku->buku_id }}" tabindex="-1" aria-labelledby="modalLabel{{ $buku->buku_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered"> {{-- Tambah modal-dialog-centered --}}
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $buku->buku_id }}">Detail Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3"> {{-- Beri sedikit jarak antar kolom --}}
                                                <div class="col-md-4 text-center text-md-start">
                                                    <img src="{{ asset($buku->buku_gambar ?? 'storage/buku_pictures/default_book.png') }}"
                                                         alt="Cover {{ $buku->buku_judul }}"
                                                         class="img-fluid rounded shadow-sm mb-3 mb-md-0"
                                                         style="max-height: 300px; width: auto;"> {{-- Batasi tinggi gambar di modal --}}
                                                </div>
                                                <div class="col-md-8">
                                                    <h4 class="mb-3">{{ $buku->buku_judul }}</h4>
                                                    <table class="table table-sm table-borderless"> {{-- Gunakan tabel untuk kerapian --}}
                                                        <tr>
                                                            <td style="width: 120px;"><i class="fas fa-user fa-fw me-2 text-muted"></i><strong>Penulis</strong></td>
                                                            <td>: {{ $buku->penulis->penulis_nama_id ?? 'N/A' }}</td>
                                                        </tr>
                                                         <tr>
                                                            <td><i class="fas fa-tag fa-fw me-2 text-muted"></i><strong>Kategori</strong></td>
                                                            <td>: {{ $buku->kategori->kategori_nama ?? 'N/A' }}</td>
                                                        </tr>
                                                         <tr>
                                                            <td><i class="fas fa-building fa-fw me-2 text-muted"></i><strong>Penerbit</strong></td>
                                                            <td>: {{ $buku->penerbit->penerbit_nama ?? 'N/A' }}</td>
                                                        </tr>
                                                         <tr>
                                                            <td><i class="fas fa-archive fa-fw me-2 text-muted"></i><strong>Rak</strong></td>
                                                            <td>: {{ $buku->rak->rak_nama ?? 'N/A' }} ({{ $buku->rak->rak_lokasi ?? 'N/A' }})</td>
                                                        </tr>
                                                         <tr>
                                                            <td><i class="fas fa-barcode fa-fw me-2 text-muted"></i><strong>ISBN</strong></td>
                                                            <td>: {{ $buku->buku_isbn ?? '-' }}</td>
                                                        </tr>
                                                         <tr>
                                                            <td><i class="fas fa-calendar-alt fa-fw me-2 text-muted"></i><strong>Tahun Terbit</strong></td>
                                                            <td>: {{ $buku->buku_thnterbit ?? '-' }}</td>
                                                        </tr>
                                                         <tr>
                                                            <td><i class="fas fa-box-open fa-fw me-2 text-muted"></i><strong>Stok Tersisa</strong></td>
                                                            <td>: <span class="badge bg-{{$buku->buku_stok > 0 ? 'success' : 'danger'}}">{{ $buku->buku_stok }}</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                <i class="fas fa-times me-1"></i> Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning text-center" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> Belum ada buku yang tersedia untuk dipinjam.
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tombol submit bisa juga ditaruh di bawah jika daftar panjang --}}
                    {{-- <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart me-2"></i>Pinjam Buku Terpilih
                        </button>
                    </div> --}}
                </form>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $bukus->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </main>
        @include('template.footer')
    </div>
</div>
@endsection

@section('scripts') {{-- Atau tempat lain di layout Anda untuk JS --}}
<script>
    // Optional: Tambahkan validasi di sisi client jika diperlukan
    // Contoh: Memastikan total buku yang dipilih tidak melebihi batas tertentu
</script>
@endsection