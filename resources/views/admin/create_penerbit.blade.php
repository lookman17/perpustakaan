@extends('template.layout')
@php
    $user = Auth::user();
@endphp

@section('title', 'Tambah Penerbit')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Penerbit</h1>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Buku Baru</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('action.createpenerbit') }}" method="POST" class="row g-3">
                            @csrf

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama Penerbit</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama penerbit" required>
                            </div>

                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat Penerbit</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat penerbit" required>
                            </div>

                            <div class="col-md-6">
                                <label for="notelp" class="form-label">No Telp Penerbit</label>
                                <input type="tel" name="notelp" id="notelp" class="form-control" placeholder="Masukkan nomor telepon penerbit" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Penerbit</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email penerbit" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('Penerbit') }}" class="btn btn-secondary ms-2">
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
