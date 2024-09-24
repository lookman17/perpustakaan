@extends('template.layout')

@section('title', 'Penulis - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
@include('template.sidebar_admin')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Penulis</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Halaman Data Penulis</li>
            </ol>
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
            <a href="{{ route('create_penulis') }}" class="btn btn-primary mb-3">Create Penulis</a>

            <div class="table-responsive card bg-light">
                <table class="table table-bordered">
                    <thead class="table table-dark">
                        <tr>
                            <th>Nama Penulis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penuliss as $p)
                        <tr>
                            <td>{{ $p->penulis_nama_id }}</td>
                            <td>
                                <a href="{{ route('edit_penulis', $p->penulis_id) }}" class="btn btn-warning fas fa-pencil">Update</a>
                                <form action="{{ route('delete_penulis', $p->penulis_id) }}" method="POST" style="display:inline;"onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger fas fa-trash">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
