@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Halaman Penerbit')

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
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-light rounded-3 p-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-primary fw-medium"></i>Penerbit Buku</a></li>
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
                <a href="{{ route('create_penerbit') }}">
                    <button class="btn btn-primary my-3">Tambah Penerbit</button>
                </a>

                <div class="table-responsive card bg-light">
                    <div class="table-responsive card bg-light">
                        <table class="table table-bordered">
                            <thead class="table ">
                                <tr>
                                    <th scope="row">No</th>
                                    <th scope="row">Nama Penerbit</th>
                                    <th scope="row">Alamat Penerbit</th>
                                    <th scope="row">No Telp Penerbit</th>
                                    <th scope="row">Email Penerbit</th>
                                    <th scope="row">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penerbit as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->penerbit_nama }}</td>
                                    <td>{{ $item->penerbit_alamat }}</td>
                                    <td>{{ $item->penerbit_notelp }}</td>
                                    <td>{{ $item->penerbit_email }}</td>
                                    <td class="d-flex align-items-center gap-2">
                                        <a href="{{ route('update_penerbit', ['penerbit_id' => $item->penerbit_id]) }}">
                                            <button class="btn btn-warning"><i class="fas fa-pencil"></i></button>
                                        </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $item->penerbit_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="hapusModal{{ $item->penerbit_id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $item->penerbit_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form action="{{ route('penerbit.delete', ['penerbit_id' => $item->penerbit_id]) }}" method="POST">

                                          @csrf
                                          @method('DELETE')
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="hapusModalLabel{{ $item->penerbit_id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="text-center text-warning mb-3">
                                                  <i class="fas fa-exclamation-triangle fa-3x"></i>
                                              </div>
                                              Apakah Anda yakin ingin menghapus    <strong>{{ $item->penerbit_nama }}</strong>?
        
                                          
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

                </div>
                {{ $penerbit->links('vendor.pagination.bootstrap-5') }}
            </div>
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
