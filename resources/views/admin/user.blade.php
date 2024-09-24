@extends('template.layout')

@section('title', 'Daftar Pengguna - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Daftar Pengguna</h1>
                <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah Pengguna</a>
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Level</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->user_id }}</td>
                            <td>{{ $user->user_nama }}</td>
                            <td>{{ $user->user_username }}</td>
                            <td>{{ $user->user_email }}</td>
                            <td>{{ $user->user_level }}</td>
                            <td>
                                <a href="{{ route('user.edit', $user->user_id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection
