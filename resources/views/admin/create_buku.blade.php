@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Tambah Buku - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>

            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Tambah Buku</li>
                </ol>
            
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Buku Baru</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('action.create_buku') }}" method="POST" enctype="multipart/form-data">
                            @csrf
            
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
            
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Berhasil!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
            
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Gagal!</strong> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="judul_buku" class="form-label">Judul Buku *</label>
                                    <input type="text" class="form-control" name="judul_buku" id="judul_buku" placeholder="Masukkan judul buku" required>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="isbn" class="form-label">Nomor ISBN *</label>
                                    <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Masukkan nomor ISBN" required>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="penulis_id" class="form-label">Penulis *</label>
                                    <select name="penulis_id" id="penulis_id" class="form-select" required>
                                        <option value="" disabled selected>-Pilih Penulis-</option>
                                        @foreach($penulis as $p)
                                            <option value="{{ $p->penulis_id }}">{{ $p->penulis_nama_id }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="penerbit_id" class="form-label">Penerbit *</label>
                                    <select name="penerbit_id" id="penerbit_id" class="form-select" required>
                                        <option value="" disabled selected>-Pilih Penerbit-</option>
                                        @foreach($penerbit as $p)
                                            <option value="{{ $p->penerbit_id }}">{{ $p->penerbit_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="tahun_terbit" class="form-label">Tahun Terbit *</label>
                                    <input type="number" class="form-control" name="tahun_terbit" id="tahun_terbit" placeholder="Contoh: 2023" required>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="kategori_id" class="form-label">Kategori *</label>
                                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                                        <option value="" disabled selected>-Pilih Kategori-</option>
                                        @foreach($kategori as $k)
                                            <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="rak_id" class="form-label">Rak Buku *</label>
                                    <select name="rak_id" id="rak_id" class="form-select" required>
                                        <option value="" disabled selected>-Pilih Rak Buku-</option>
                                        @foreach($rak as $r)
                                            <option value="{{ $r->rak_id }}">{{ $r->rak_nama }} ({{ $r->rak_kapasitas }})</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="buku_stok" class="form-label">Stok Buku *</label>
                                    <input type="number" name="buku_stok" id="buku_stok" class="form-control" placeholder="Masukkan stok buku" required>
                                </div>
            
                                <div class="col-md-6">
                                    <label for="buku_gambar" class="form-label">Gambar Buku *</label>
                                    <input type="file" class="form-control" name="buku_gambar" id="buku_gambar" accept="image/*" required>
                                </div>
                            </div>
            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i>Simpan
                                </button>
                                <a href="{{ route('buku') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left-circle"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
