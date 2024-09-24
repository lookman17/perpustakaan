@extends('template.layout')

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
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Nama Pengguna</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">Pilih Pengguna</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->user_id }}">{{ $user->user_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_peminjaman" class="form-label">Tanggal Peminjaman</label>
                        <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="buku_ids" class="form-label">Pilih Buku</label>
                        <select name="buku_ids[]" id="buku_ids" class="form-select" multiple required>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->buku_id }}">{{ $buku->buku_judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
