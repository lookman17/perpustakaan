@extends('template.layout')

@section('title', 'Daftar Peminjaman')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Peminjaman</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Data Peminjaman</li>
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
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>
                <div class="table-responsive card bg-light">
                    <table class="table table-bordered">
                        <thead class="table ">
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Kembali</th>
                                <th>Status Kembali</th>
                                <th>Detail Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->user->user_nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam)->format('d-m-Y') }}</td>
                                    <td>{{ $peminjaman->peminjaman_tglkembali ? \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->format('d-m-Y') : 'Belum Kembali' }}</td>

                                    <!-- Status Kembali -->
                                    <td>
                                        @if ($peminjaman->peminjaman_statuskembali)
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning">Masih Dipinjam</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($peminjaman->details->isEmpty())
                                            Tidak ada buku
                                        @else
                                            @foreach ($peminjaman->details as $detail)
                                                {{ $detail->buku->buku_judul }}<br>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('peminjaman.status', $peminjaman->peminjaman_id) }}" class="btn btn-warning text-white">
                                            Status
                                        </a>

                                        <form action="{{ route('peminjaman.destroy', $peminjaman->peminjaman_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peminjaman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
</div>
@endsection
