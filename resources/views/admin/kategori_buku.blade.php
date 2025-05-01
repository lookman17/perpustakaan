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
                <h1 class="mt-4">Kategori Buku</h1>
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

                <a href="{{ route('create_kategori_buku') }}" class="btn btn-primary mb-3">Create Kategori Buku</a>
                <div class="table-responsive card bg-light">
                    <table class="table table-bordered">
                        <thead class="table ">
                            <tr>
                                <th>No</th>
                                <th>Kategori Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kategoris as $index => $kategori)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kategori->kategori_nama }}</td>
                                    <td>
                                        <a href="{{ route('update_kategori', ['kategori_id' => $kategori->kategori_id]) }}">
                                            <button class="btn btn-warning"><i class="fas fa-pencil"></i></button>
                                        </a>
                                                                                                                  
                                    
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $kategori->kategori_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                                <div class="modal fade" id="hapusModal{{ $kategori->kategori_id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $kategori->kategori_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <form action="{{ route('kategori.delete', ['kategori_id' => $kategori->kategori_id]) }}" method="POST" style="display:inline;">
                                          @csrf
                                          @method('DELETE')
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="hapusModalLabel{{ $kategori->kategori_id }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                          </div>-=
                                          <div class="modal-body">
                                              <div class="text-center text-warning mb-3">
                                                  <i class="fas fa-exclamation-triangle fa-3x"></i>
                                              </div>
                                              Apakah Anda yakin ingin menghapus    <strong>{{ $kategori->kategori_nama }}</strong>?
        
                                          
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
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
