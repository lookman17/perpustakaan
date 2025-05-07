@extends('template.layout')
@php
    $user = Auth::user();
@endphp
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
                            <div class="table-responsive">
                                <table class="table">
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
                                                    @foreach ($peminjaman->details as $detail)
                                                        {{ $detail->buku->buku_judul }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $peminjaman->peminjaman_tglpinjam }}</td>
                                                <td>
                                                    @if ($peminjaman->peminjaman_statuskembali)
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-warning">Masih Dipinjam</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $peminjaman->peminjaman_id }}">
                                                        Lihat Detail
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal untuk detail peminjaman -->
                                            {{-- Pastikan Font Awesome sudah di-load di layout utama Anda --}}



                                            <!-- Modal Detail Peminjaman -->
                                            <div class="modal fade" id="detailModal{{ $peminjaman->peminjaman_id }}"
                                                tabindex="-1"
                                                aria-labelledby="detailModalLabel{{ $peminjaman->peminjaman_id }}"
                                                aria-hidden="true">
                                                {{-- Gunakan modal-lg untuk ukuran lebih besar --}}
                                                <div
                                                    class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                    {{-- Tambah scrollable jika konten panjang --}}
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light">
                                                            <h5 class="modal-title"
                                                                id="detailModalLabel{{ $peminjaman->peminjaman_id }}">
                                                                <i class="fas fa-receipt me-2"></i>Detail Peminjaman
                                                                #{{ $peminjaman->peminjaman_id }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body p-4">

                                                            {{-- Informasi Umum Peminjaman (Ditampilkan Sekali) --}}
                                                            <h6 class="mb-3 text-primary"><i
                                                                    class="fas fa-info-circle me-2"></i>Informasi Peminjaman
                                                            </h6>
                                                            <dl class="row loan-details-list">
                                                                <dt class="col-sm-4"><i
                                                                        class="fas fa-calendar-alt fa-fw me-2 text-muted"></i>Tgl
                                                                    Pinjam</dt>
                                                                <dd class="col-sm-8">:
                                                                    {{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam)->isoFormat('DD MMMM YYYY') }}
                                                                </dd>

                                                                <dt class="col-sm-4"><i
                                                                        class="fas fa-calendar-check fa-fw me-2 text-muted"></i>Tgl
                                                                    Kembali</dt>
                                                                <dd class="col-sm-8">:
                                                                    @if ($peminjaman->peminjaman_tglkembali)
                                                                        {{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->isoFormat('DD MMMM YYYY') }}
                                                                    @else
                                                                        <span class="text-muted">Belum Dikembalikan</span>
                                                                    @endif
                                                                </dd>

                                                                <dt class="col-sm-4"><i
                                                                        class="fas fa-hourglass-half fa-fw me-2 text-muted"></i>Status
                                                                </dt>
                                                                <dd class="col-sm-8">:
                                                                    @if ($peminjaman->peminjaman_statuskembali)
                                                                        <span class="badge bg-success"><i
                                                                                class="fas fa-check me-1"></i>
                                                                            Selesai</span>
                                                                    @else
                                                                        <span class="badge bg-warning text-dark"><i
                                                                                class="fas fa-clock me-1"></i> Masih
                                                                            Dipinjam</span>
                                                                    @endif
                                                                </dd>

                                                                <dt class="col-sm-4"><i
                                                                        class="fas fa-money-bill-wave fa-fw me-2 text-muted"></i>Denda
                                                                </dt>
                                                                <dd class="col-sm-8">:
                                                                    Rp{{ number_format($peminjaman->denda_terhitung ?? ($peminjaman->peminjaman_denda ?? 0), 0, ',', '.') }}
                                                                    {{-- Tampilkan denda_terhitung jika ada (lebih real-time), fallback ke denda tersimpan --}}
                                                                </dd>

                                                                <dt class="col-sm-4"><i
                                                                        class="fas fa-sticky-note fa-fw me-2 text-muted"></i>Catatan
                                                                </dt>
                                                                <dd class="col-sm-8">:
                                                                    {{ $peminjaman->peminjaman_note ?: '-' }}</dd>
                                                                {{-- Tampilkan '-' jika catatan kosong --}}

                                                            </dl>

                                                            <hr class="my-4">

                                                            {{-- Detail Buku yang Dipinjam --}}
                                                            <h6 class="mb-3 text-primary"><i
                                                                    class="fas fa-book me-2"></i>Buku yang Dipinjam</h6>
                                                            @forelse($peminjaman->details as $index => $detail)
                                                                <div class="card mb-3 shadow-sm">
                                                                    <div class="card-body">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-md-2 text-center mb-2 mb-md-0">
                                                                                <img src="{{ asset($detail->buku->buku_gambar ?? 'storage/buku_pictures/default_book.png') }}"
                                                                                    {{-- Pastikan ada default image --}}
                                                                                    alt="Cover {{ $detail->buku->buku_judul }}"
                                                                                    class="book-detail-img img-fluid">
                                                                            </div>
                                                                            <div class="col-md-10">
                                                                                <h6 class="card-title mb-1 fw-bold">
                                                                                    {{ $detail->buku->buku_judul }}</h6>
                                                                                <small class="text-muted d-block mb-1">
                                                                                    <i class="fas fa-user fa-fw me-1"></i>
                                                                                    {{ $detail->buku->penulis->penulis_nama_id ?? 'Penulis tidak diketahui' }}
                                                                                </small>
                                                                                <small class="text-muted d-block">
                                                                                    <i
                                                                                        class="fas fa-barcode fa-fw me-1"></i>
                                                                                    ISBN:
                                                                                    {{ $detail->buku->buku_isbn ?? '-' }}
                                                                                </small>
                                                                                {{-- Anda bisa tambahkan info buku lain jika perlu --}}
                                                                                {{-- <p class="mb-1"><strong>Jumlah Pinjam:</strong> {{ $detail->detail_jumlah ?? 1 }}</p> --}} {{-- Jika ada field jumlah --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {{-- @if (!$loop->last) --}}
                                                                {{-- <hr class="my-3"> --}} {{-- Garis pemisah antar buku jika ada lebih dari 1, tapi card sudah cukup memisahkan --}}
                                                                {{-- @endif --}}
                                                            @empty
                                                                <div class="alert alert-warning text-center" role="alert">
                                                                    <i class="fas fa-exclamation-triangle me-2"></i> Tidak
                                                                    ada detail buku ditemukan untuk peminjaman ini.
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-1"></i> Tutup
                                                            </button>
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
                    <br>
                    {{ $peminjamans->links('vendor.pagination.bootstrap-5') }}
                </div>
                <br>
            </main>
            @include('template.footer')
        </div>
    </div>
    <style>
        /* Tambahkan ini di file CSS Anda atau di <style> tag di <head> */
        .book-detail-img {
            width: 100%;
            /* Responsif di dalam kolom */
            max-width: 120px;
            /* Batasi lebar maksimum */
            height: auto;
            /* Biarkan tinggi menyesuaikan */
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            /* Border tipis */
        }

        .loan-details-list dt {
            /* Definisi term dalam description list */
            font-weight: bold;
            min-width: 150px;
            /* Agar titik dua (:) sejajar */
            padding-right: 0.5rem;
        }

        .loan-details-list dd {
            /* Definisi description */
            margin-bottom: 0.5rem;
        }
    </style>
@endsection
