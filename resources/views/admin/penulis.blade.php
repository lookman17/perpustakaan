@extends('template.layout')
@php
    $user = Auth::user();
@endphp@section('title', 'Penulis - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
@include('template.sidebar_admin')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Penulis</h1>
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-light rounded-3 p-3 shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-primary fw-medium">Penulis Buku</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola</li>
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
                <div class="col-md-1"> <!-- Tambahkan margin bawah pada mobile -->
                    <a href="{{ route('create_penulis') }}" class="btn btn-primary w-100"><i class="fas fa-plus"></i></a>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('Penulis') }}" method="GET">
                        <div class="input-group w-100">
                            <input type="text" name="search" class="form-control" placeholder="Cari Rak..." value="{{ request('search') }}">
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
                            <th>Nama Penulis</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penuliss as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->penulis_nama_id }}</td>
                            <td>{{ $p->penulis_tmptlahir }}</td>
                            <td>{{ $p->penulis_tgllahir}}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('edit_penulis', $p->penulis_id) }}" class="btn btn-warning">
                                        <i class="fas fa-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $p->penulis_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $p->penulis_id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $p->penulis_id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('delete_penulis', ['penulis_id' => $p->penulis_id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusModalLabel{{ $p->penulis_id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center text-warning mb-3">
                                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                                            </div>
                                            Apakah Anda yakin ingin menghapus <strong>{{ $p->penulis_nama_id }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $penuliss->links('vendor.pagination.bootstrap-5') }}
        </div>
        
    </main>
    @include('template.footer')
</div>
@endsection
