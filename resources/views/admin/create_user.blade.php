@extends('template.layout')

@section('title', 'Tambah Pengguna - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Pengguna</h1>
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="user_nama">Nama Pengguna *</label>
                        <input type="text" name="user_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user_alamat">Alamat *</label>
                        <input type="text" name="user_alamat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user_username">Username *</label>
                        <input type="text" name="user_username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email *</label>
                        <input type="email" name="user_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user_notelp">No Telepon *</label>
                        <input type="text" name="user_notelp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user_password">Password *</label>
                        <input type="password" name="user_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="user_level">Level *</label>
                        <select name="user_level" class="form-control" required>
                            <option value="admin">Admin</option>
                            <option value="anggota">Siswa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
