@extends('template.layout')

@section('title', 'Halaman Update Kategori Buku')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Kategori Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Update Data Kategori Buku</li>
                </ol>
                <form action="{{ route('kategori.update', $kategori->kategori_id) }}" class="row my-4 gap-3" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="kategori_nama" class="form-label">Nama Kategori</label>
                        <input type="text" name="kategori_nama" id="kategori_nama" class="form-control" value="{{ $kategori->kategori_nama }}" required>
                        <br>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <button class="btn btn-success" type="submit">Tambahkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
