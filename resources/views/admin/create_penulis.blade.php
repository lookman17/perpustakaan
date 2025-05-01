@extends('template.layout')
@php
    $user = Auth::user();
@endphp

@section('title', 'Tambah Penulis')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Penulis</h1>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Buku Baru</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('action.create_penulis') }}" method="POST" class="row g-3">
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
                                <label for="penulis_nama_id" class="form-label">Nama Penulis</label>
                                <input type="text" name="penulis_nama_id" id="penulis_nama_id" class="form-control" placeholder="Masukkan nama penulis" required>
                            </div>

                            <div class="col-md-6">
                                <label for="penulis_tmptlahir" class="form-label">Tempat Lahir</label>
                                <input type="text" name="penulis_tmptlahir" id="penulis_tmptlahir" class="form-control" placeholder="Masukkan tempat lahir penulis" required>
                            </div>

                            <div class="col-md-6">
                                <label for="penulis_tgllahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" name="penulis_tgllahir" id="penulis_tgllahir" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Tambah Simpan
                                </button>
                                <a href="{{ route('Penulis') }}" class="btn btn-secondary ms-2">
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
