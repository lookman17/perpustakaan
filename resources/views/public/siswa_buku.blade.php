@extends('template.layout')

@section('title', 'Daftar buku - Siswa Perpustakaan')

@section('header')
    @include('template.navbar_siswa')
@endsection

@section('main')
<style>
    .book-img {
    width: 200px;  
    height: 300px;
    object-fit: cover; 
    border-radius: 10px;
    box-shadow:4px 6px 2px; 
}

</style>
<div id="layoutSidenav">
    @include('template.sidebar_siswa')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Buku</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Halaman Daftar Buku</li>
                    </ol>
                    <div class="row mt-4 mb-5">
                        @foreach ($bukus as $buku)
                            <!-- Set setiap card menjadi 4 per baris di layar besar -->
                            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Gambar Buku -->
                                        @if($buku->buku_gambar && file_exists(public_path($buku->buku_gambar)))
                                            <img src="{{ asset($buku->buku_gambar) }}" alt="{{ $buku->buku_judul }}" class="book-img mb-3" />
                                        @else
                                            <img src="{{ asset('storage/buku_pictures/default_image.png') }}" alt="Gambar tidak tersedia" class="book-img mb-3" />
                                        @endif
    
                                        <hr />
                                        <p class="text-center fw-bolder fs-5">{{ $buku->buku_judul }}</p>
                                        <p class="text-center mb-3">Ditulis oleh {{ $buku->penulis->penulis_nama_id }}</p>
                                        <p class="text-center mb-3">{{ $buku->kategori->kategori_nama }}</p>
    
                                        <button type="button" class="btn btn-primary d-block mx-auto w-75" data-bs-toggle="modal" data-bs-target="#confirmModal{{ $buku->buku_id }}">
                                            Detail
                                        </button>
    
                                        <!-- Modal Detail Buku -->
                                        <div class="modal fade" id="confirmModal{{ $buku->buku_id }}" tabindex="-1" aria-labelledby="confirmModal{{ $buku->buku_id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmModal{{ $buku->buku_id }}Label">Peminjaman Buku</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div>
                                                            <span>Detail Buku:</span>
                                                            <ul class="mt-2">
                                                                <li>Judul: {{ $buku->buku_judul }}</li>
                                                                <li>Kategori: {{ $buku->kategori->kategori_nama }}</li>
                                                                <li>Penulis: {{ $buku->penulis->penulis_nama_id }}</li>
                                                                <li>Penerbit: {{ $buku->penerbit->penerbit_nama }}</li>
                                                                <li>Lokasi Rak: {{ $buku->rak->rak_lokasi }}</li>
                                                                <li>Serial ISBN: {{ $buku->buku_isbn }}</li>
                                                            </ul>
                                                        </div>
                                                        <div class="mt-3">
                                                            <span>Keterlambatan mengembalikan buku kemungkinan akan dikenakan denda. Apakah anda ingin meminjam buku ini?</span>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <a href="{{ route('buku.pinjam', ['buku_id' => $buku['buku_id']]) }}" class="btn btn-primary">Pinjam</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $bukus->links('vendor.pagination.bootstrap-5') }}
                </div>
            </main>
        </div>
    </div>
    @endsection
    