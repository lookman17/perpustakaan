@extends('template.layout')

@section('title', 'Peminjaman - Siswa Perpustakaan')

@section('header')
    @include('template.navbar_siswa')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_siswa')
    <div id="layoutSidenav_content">
        <main>

            <div class="container-fluid px-4">
                <h1 class="mt-4">Daftar Peminjaman Siswa</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Daftar Peminjaman Siswa</li>
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
                <div class="row gap-4">
                    <div class="col">
                        <div class="table-responsive card bg-light">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @foreach($peminjaman->details as $detail)
                                                {{ $detail->buku->buku_judul }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $peminjaman->peminjaman_tglpinjam }}</td>
                                        <td class="badge  {{ $peminjaman->peminjaman_statuskembali ? 'bg-success' : 'bg-warning' }} text-white">
                                            {{ $peminjaman->peminjaman_statuskembali ? 'Selesai' : 'Dipinjam' }}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $peminjaman->peminjaman_id }}">
                                                Lihat Detail
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal untuk detail peminjaman -->
                                    <div class="modal fade" id="detailModal{{ $peminjaman->peminjaman_id }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailModalLabel"><strong>Detail Peminjaman</strong></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Loop untuk setiap detail peminjaman -->
                                                    @foreach($peminjaman->details as $detail)
                                                        <div class="d-flex align-items-start mb-3">
                                                            <!-- Informasi Buku -->
                                                            <div class="me-3">
                                                                <p><strong>Judul Buku:</strong> {{ $detail->buku->buku_judul }}</p>
                                                                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->peminjaman_tglpinjam }}</p>
                                                                <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->peminjaman_tglkembali ?? 'Belum Kembali' }}</p>
                                                                <p><strong>Status:</strong> {{ $peminjaman->peminjaman_statuskembali ? 'Selesai' : 'Dipinjam' }}</p>
                                                                <p><strong>Catatan:</strong> {{ $peminjaman->peminjaman_note ?? 'Tidak ada catatan' }}</p>
                                                                <p><strong>Denda:</strong> {{ number_format($peminjaman->peminjaman_denda, 2, ',', '.') }}</p>
                                                            </div>
                                                            
                                                            <!-- Gambar Buku -->
                                                            <div>
                                                                <img src="{{ asset($detail->buku->buku_gambar) }}" alt="{{ $detail->buku->buku_judul }}" style="width: 150px; height: 200px; object-fit: cover; border-radius: 8px;">
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data peminjaman.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
