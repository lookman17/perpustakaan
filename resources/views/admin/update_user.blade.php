@extends('template.layout')

@section('title', 'Edit User - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit User</h1>
                <form action="{{ route('user.update', $user->user_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="user_nama">Nama User</label>
                        <input type="text" name="user_nama" class="form-control" value="{{ $user->user_nama }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email</label>
                        <input type="email" name="user_email" class="form-control" value="{{ $user->user_email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user_username">Username</label>
                        <input type="text" name="user_username" class="form-control" value="{{ $user->user_username }}" required>
                    </div>
                    <div class="form-group">
                        <label for="user_level">Level</label>
                        <select name="user_level" class="form-control" required>
                            <option value="admin" {{ $user->user_level == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="anggota" {{ $user->user_level == 'anggota' ? 'selected' : '' }}>Anggota</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="user_password">Password (Kosongkan jika tidak ingin mengganti)</label>
                        <input type="password" name="user_password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
