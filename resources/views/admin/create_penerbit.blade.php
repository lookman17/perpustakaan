@extends('template.layout')

@section('title', 'Halaman Create Penerbit')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Penerbit</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Create Data Penerbit</li>
                </ol>
                <form action="{{ route('action.createpenerbit') }}" class="row my-4 gap-3" method="post">
                    @csrf
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="nama" class="form-label">Nama Penerbit</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama penerbit" required>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="alamat" class="form-label">Alamat Penerbit</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat penerbit" required>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="notelp" class="form-label">No Telp Penerbit</label>
                        <input type="number" name="notelp" id="notelp" class="form-control" placeholder="Masukkan notelp penerbit" required>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="email" class="form-label">Email Penerbit</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email penerbit" required>
                    </div>
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <button class="btn btn-success" type="submit">Tambahkan</button>
                    </div>
                </form>

            </div>
        </main>

    </div>
</div>
@endsection
