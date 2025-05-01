@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Daftar buku - Siswa Perpustakaan')

@section('header')
    @include('template.navbar_siswa')
@endsection

@section('main')
<style>
    .book-img {
        width: 100%;  
        height: 300px;
        object-fit: cover; 
        border-radius: 10px;
        box-shadow: 0px 6px 2px;
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

                <!-- Form untuk memilih buku -->
                <form action="{{ route('buku.pinjam.multiple') }}" method="POST">
                    @csrf
                    <div class="">
                        <button type="submit" class="btn btn-primary">Pinjam Buku Terpilih</button>
                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4 mt-4 mb-5">
                        @foreach ($bukus as $buku)
                            <div class="col">
                                <div class="card h-100 bg bg-light text-dark">
                                    <div class="card-body text-center">
                                        @if($buku->buku_gambar && file_exists(public_path($buku->buku_gambar)))
                                            <img src="{{ asset($buku->buku_gambar) }}" alt="{{ $buku->buku_judul }}" class="book-img mb-3" />
                                        @else
                                            <img src="{{ asset('storage/buku_pictures/default_image.png') }}" alt="Gambar tidak tersedia" class="book-img mb-3" />
                                        @endif

                                        <hr />
                                        <p class="fw-bolder fs-5 my-0">{{ $buku->buku_judul }}</p>
                                        <p class="mb-1">Ditulis oleh {{ $buku->penulis->penulis_nama_id }}</p>
                                        <p class="mb-2">{{ $buku->kategori->kategori_nama }}</p>

                                        <!-- Checkbox untuk memilih buku -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="buku_ids[]" value="{{ $buku->buku_id }}" id="buku{{ $buku->buku_id }}">
                                            <label class="form-check-label" for="buku{{ $buku->buku_id }}">
                                                Pilih buku ini
                                            </label>
                                        </div>

                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalDetailBuku{{ $buku->buku_id }}">
                                            Lihat Detail Buku
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail Buku -->
                            <div class="modal fade" id="modalDetailBuku{{ $buku->buku_id }}" tabindex="-1" aria-labelledby="modalDetailBukuLabel{{ $buku->buku_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalDetailBukuLabel{{ $buku->buku_id }}">Detail Buku</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{ asset($buku->buku_gambar ? $buku->buku_gambar : 'storage/buku_pictures/default_image.png') }}" alt="{{ $buku->buku_judul }}" class="img-fluid rounded">
                                                </div>
                                                <div class="col-md-8">
                                                    <h5>{{ $buku->buku_judul }}</h5>
                                                    <p><strong>Penulis:</strong> {{ $buku->penulis->penulis_nama_id }}</p>
                                                    <p><strong>Kategori:</strong> {{ $buku->kategori->kategori_nama }}</p>
                                                    <p><strong>Penerbit:</strong> {{ $buku->penerbit->penerbit_nama }}</p>
                                                    <p><strong>Nama Rak:</strong> {{ $buku->rak->rak_nama }}</p>
                                                    <p><strong>Lokasi Rak:</strong> {{ $buku->rak->rak_lokasi }}/{{$buku->rak->rak_kapasitas}}</p>
                                                    <p><strong>Nomor ISBN:</strong> {{ $buku->buku_isbn }}</p>
                                                    <p><strong>Tahun Terbit:</strong> {{ $buku->buku_thnterbit }}</p>
                                                    <p><strong>Stok Buku:</strong> {{ $buku->buku_stok }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                </form>
                
                {{ $bukus->links('vendor.pagination.bootstrap-5') }}
            </div>
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
