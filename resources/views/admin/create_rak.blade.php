@extends('template.layout')

@section('title', 'Tambah Rak')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Rak</h1>
                <form action="{{ route('rak.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="rak_nama">Nama Rak *</label>
                        <input type="text" name="rak_nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="rak_lokasi">Lokasi *</label>
                        <input type="text" name="rak_lokasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="rak_kapasitas">Kapasitas *</label>
                        <select name="rak_kapasitas" class="form-control" required>
                            <option value="" disabled selected>Pilih Kapasitas</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Rak</button>
                    <a href="{{ route('rak.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
