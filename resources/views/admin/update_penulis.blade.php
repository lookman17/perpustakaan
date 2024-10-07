@extends('template.layout')

@section('title', 'Update Penulis - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Penulis</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Update Penulis</li>
                </ol>
                <form action="{{ route('update_penulis', $penulis->penulis_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="penulis_nama_id">Nama Penulis *</label>
                        <input type="text" name="penulis_nama_id" value="{{ $penulis->penulis_nama_id }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="penulis_tmptlahir">Tempat Lahir</label>
                        <input type="text" name="penulis_tmptlahir" value="{{ $penulis->penulis_tmptlahir }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="penulis_tgllahir">Tanggal Lahir</label>
                        <input type="date" name="penulis_tgllahir" value="{{ $penulis->penulis_tgllahir }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('Penulis') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </main>
    </div>
</div>
@endsection
