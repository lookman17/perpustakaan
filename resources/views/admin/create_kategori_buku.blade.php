@extends('template.layout')
@php
    $user = Auth::user();
@endphp

@section('title', 'Halaman Create Kategori Buku')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Kategori Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Create Data Kategori Buku</li>
                </ol>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Buku Baru</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('action.createkategoribuku') }}" method="POST" class="row g-3">
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

                            <div class="col-md-6 col-lg-4">
                                <label for="kategori_nama" class="form-label">Nama Kategori</label>
                                <input type="text" name="kategori_nama" id="kategori_nama" class="form-control" placeholder="Masukkan nama kategori" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('kategoriBuku') }}" class="btn btn-secondary ms-2">
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
