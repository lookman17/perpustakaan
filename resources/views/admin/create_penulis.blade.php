@extends('template.layout')

@section('title', 'Tambah Penulis - Admin Perpustakaan')

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
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Tambah Penulis</li>
                </ol>
                <form action="{{ route('action.create_penulis') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="penulis_nama">Nama Penulis</label>
                        <input type="text" name="penulis_nama_id" class="form-control" required> <!-- Sesuaikan name attribute -->
                    </div>
                    <div class="form-group">
                        <label for="penulis_tmptlahir">Tempat Lahir</label>
                        <input type="text" name="penulis_tmptlahir" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis_tgllahir">Tanggal Lahir</label>
                        <input type="date" name="penulis_tgllahir" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="{{ route('Penulis') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </main>
    </div>
</div>
@endsection
