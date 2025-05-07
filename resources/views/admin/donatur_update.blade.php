@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Halaman Update donatur Buku')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update don Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Update Data donatur Buku</li>
                </ol>
                <form action="{{ route('donatur.update', $donatur->donatur_id) }}" class="row my-4 gap-3" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="form-group col-12 col-md-6 col-lg-4">
                        <label for="donatur_nama" class="form-label">Donatur nama</label>
                        <input type="text" name="donatur_nama" id="donatur_nama" class="form-control" value="{{ $donatur->donatur_nama }}" required>
                        <br>
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <button class="btn btn-success" type="submit">Tambahkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
