@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Halaman Buku')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Buku</h1>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-light rounded-3 p-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-primary fw-medium"></i>Buku</a></li>
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
                <form action="{{ route('buku') }}" method="GET" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-1">
                            <a href="{{ route('create_buku') }}" class="btn btn-primary w-100"><i class="fas fa-plus"></i></a>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-5">
                            <select name="kategori" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}" {{ $selectedKategori == $kategori->kategori_id ? 'selected' : '' }}>
                                        {{ $kategori->kategori_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                
                
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table">
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Penulis Buku</th>
                                <th>Penerbit Buku</th>
                                <th>Rak Buku</th>
                                <th>Aksi</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bukus as $buku)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $buku->buku_judul }}</td>
                                <td>{{ $buku->penulis->penulis_nama_id }}</td>
                                <td>{{ $buku->penerbit->penerbit_nama }}</td>
                                <td>{{ $buku->rak->rak_lokasi }} ({{ $buku->rak->rak_nama }})</td>
                                <td>
                                    <!-- Tombol Detail -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $buku->buku_id }}">
                                        Lihat Detail
                                    </button>
                        
                                    <!-- Modal -->
                                    <div class="modal fade" id="detailModal{{ $buku->buku_id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $buku->buku_id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel{{ $buku->buku_id }}">Detail Buku</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-3">
                                                        <img src="{{ asset($buku->buku_gambar) }}" alt="{{ $buku->buku_judul }}" class="img-fluid" style="max-height: 200px;">
                                                    </div>
                                                    <p><strong>Judul Buku:</strong> {{ $buku->buku_judul }}</p>
                                                    <p><strong>Penulis:</strong> {{ $buku->penulis->penulis_nama_id }}</p>
                                                    <p><strong>Penerbit:</strong> {{ $buku->penerbit->penerbit_nama }}</p>
                                                    <p><strong>Tahun Terbit:</strong> {{ $buku->buku_thnterbit }}</p>
                                                    <p><strong>Kategori:</strong> {{ $buku->kategori->kategori_nama }}</p>
                                                    <p><strong>Rak:</strong> {{ $buku->rak->rak_lokasi }} ({{ $buku->rak->rak_nama }})</p>
                                                    <p><strong>ISBN:</strong> {{ $buku->buku_isbn }}</p>
                                                    <p><strong>donatur</strong> {{ $buku->buku_donatur}}</p>
                                                    <p><strong>Stok:</strong> {{ $buku->buku_stok }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Tombol Edit dan Hapus -->
                                    <a href="{{ route('update_buku', ['buku_id' => $buku->buku_id]) }}">
                                        <button class="btn btn-warning"><i class="fas fa-pencil"></i></button>
                                    </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $buku->buku_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="hapusModal{{ $buku->buku_id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $buku->buku_id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <form action="{{ route('buku.delete', ['buku_id' => $buku->buku_id]) }}" method="POST" style="display:inline;">

                                      @csrf
                                      @method('DELETE')
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel{{ $buku->buku_id }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                      </div>
                                      <div class="modal-body">
                                          <div class="text-center text-warning mb-3">
                                              <i class="fas fa-exclamation-triangle fa-3x"></i>
                                          </div>
                                          Apakah Anda yakin ingin menghapus    <strong>{{ $buku->buku_judul }}</strong>?
    
                                      
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
                {{ $bukus->links('vendor.pagination.bootstrap-5') }}
                
            </div>
           
        </main>
        @include('template.footer')
    </div>
</div>
<!-- Modal -->
@endsection
