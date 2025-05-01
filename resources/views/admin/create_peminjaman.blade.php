@extends('template.layout')
@php
    $user = Auth::user();
@endphp

@section('title', 'Tambah Peminjaman')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Peminjaman</h1>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Form Tambah Buku Baru</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('peminjaman.store') }}" method="POST" class="row g-3">
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
                                <label for="user_id" class="form-label">Nama Pengguna</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">Pilih Pengguna</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->user_nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                                <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="buku_ids" class="form-label">Pilih Buku</label>
                                <select name="buku_ids[]" id="buku_ids" class="form-select" multiple required>
                                    @foreach ($bukus as $buku)
                                        <option value="{{ $buku->buku_id }}">{{ $buku->buku_judul }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Gunakan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu.</small>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                                <a href="{{ route('peminjaman') }}" class="btn btn-secondary ms-2">
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
