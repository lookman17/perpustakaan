@extends('template.layout')

@section('title', 'Halaman Update Penerbit')

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
                    <li class="breadcrumb-item active">Halaman Update Data Penerbit</li>
                </ol>
                <form action="{{ route('penerbit.update', ['penerbit_id' => $penerbit->penerbit_id]) }}" class="row my-4 gap-3" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="nama" class="form-label">Nama Penerbit</label>
                        <input type="text" name="penerbit_nama" id="nama" class="form-control" placeholder="Masukkan nama penerbit" value="{{ $penerbit->penerbit_nama }}">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="alamat" class="form-label">Alamat Penerbit</label>
                        <input type="text" name="penerbit_alamat" id="alamat" class="form-control" placeholder="Masukkan alamat penerbit" value="{{ $penerbit->penerbit_alamat }}">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="notelp" class="form-label">No Telp Penerbit</label>
                        <input type="text" name="penerbit_notelp" id="notelp" class="form-control" placeholder="Masukkan no telp penerbit" value="{{ $penerbit->penerbit_notelp }}">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="email" class="form-label">Email Penerbit</label>
                        <input type="email" name="penerbit_email" id="email" class="form-control" placeholder="Masukkan email penerbit" value="{{ $penerbit->penerbit_email }}">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <button type="submit" class="btn btn-warning"><i class="fas fa-pencil"></i> Update</button>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif (session('updated'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('updated') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
