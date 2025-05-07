@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Kategori Buku - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Donatur Buku</h1>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-light rounded-3 p-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-primary fw-medium"></i> Kategori Buku</a></li>
                        <li class="breadcrumb-item active" aria-current="page">kelola</li>
                    </ol>
                </nav>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('deleted'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('deleted') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row mb-3 align-items-center">
                    <div class="col-md-1">
                        <a href="{{ route('create_donatur') }}" class="btn btn-primary w-100"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('donatur') }}" method="GET">
                            <div class="input-group w-100">
                                <input type="text" name="search" class="form-control" placeholder="Cari donatur..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                      
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Nama Donatur</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donaturs as $index => $donatur)
                                <tr>
                                    <td>{{ $index   + 1 }}</td>
                                    <td>{{ $donatur->donatur_nama }}</td>
                                    <td>
                                        <a href="{{ route('update_donatur', ['donatur_id' => $donatur->donatur_id]) }}">
                                            <button class="btn btn-warning"><i class="fas fa-pencil"></i></button>
                                        </a>
                                        <form action="{{ route('donatur.delete', ['donatur_id' => $donatur->donatur_id]) }}" method="POST">

                                            @csrf
                                            @method('DELETE')
                                            <button>o</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $donaturs->links('vendor.pagination.bootstrap-5') }}

                </div>
           
                
                
            </div>
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
