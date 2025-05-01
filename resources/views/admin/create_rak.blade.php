@extends('template.layout')
@php
    $user = Auth::user();
@endphp

@section('title', 'Tambah Rak')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Rak</h1>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Buku Baru</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rak.store') }}" method="POST" class="row g-3">
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
                                <label for="rak_nama" class="form-label">Nama Rak</label>
                                <input type="text" name="rak_nama" id="rak_nama" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="rak_lokasi" class="form-label">Lokasi</label>
                                <input type="text" name="rak_lokasi" id="rak_lokasi" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label for="rak_kapasitas" class="form-label">Kapasitas</label>
                                <select name="rak_kapasitas" id="rak_kapasitas" class="form-select" required>
                                    <option value="" disabled selected>Pilih Kapasitas</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('rak.index') }}" class="btn btn-secondary ms-2">
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
