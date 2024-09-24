@extends('template.layout')

@section('title', 'Peminjaman - Siswa Perpustakaan')

@section('header')
    @include('template.navbar_siswa')
@endsection

@section('main')
<div id="layoutSidenav">
        @include('template.sidebar_siswa')
        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Peminjaman Buku</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Halaman Peminjaman Buku</li>
                        </ol>
                        <form action="">
                            <div class="row">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="nama" class="form-label">Nama Peminjam *</label>
                                    <input type="text" name="nama" id="nama" class="form-control">
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="tgl_pinjam" class="form-label">Tanggal Pinjam *</label>
                                    <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control">
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-12 col-md-4 form-group">
                                    <label for="tgl_kembali" class="form-label">Tanggal Kembali *</label>
                                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-control">
                                </div>
                                <div class="col-12 col-md-4 form-group">
                                    <label for="buku" class="form-label">Buku 1 *</label>
                                    <select class="form-control" name="buku" id="buku">
                                        <option selected>-Pilih Buku-</option>
                                        <option value="bulan">Bulan - Tere Liye</option>
                                        <option value="bumi">Bumi - Tere Liye</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-12 col-md-4 form-group">
                                    <button class="btn btn-primary">Buat Peminjaman</button>
                                    <button class="btn btn-warning">Tambah Buku</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endsection