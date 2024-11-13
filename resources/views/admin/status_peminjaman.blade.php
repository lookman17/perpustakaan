@extends('template.layout')

@section('title', 'Status Peminjaman')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Status Peminjaman</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Status Peminjaman</li>
                </ol>

                <div class="card bg-light" style="padding-bottom: 20px">
                    <div class="card-body">
                        <h5>Nama Pengguna     : {{ $peminjaman->user->user_nama }}</h6>
                        <h5>Tanggal Peminjaman: {{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam)->format('d-m-Y') }}</h6>
                        <h5>Denda: Rp {{ number_format($peminjaman->peminjaman_denda, 2, ',', '.') }}</h6>

                        <form action="{{ route('peminjaman.update-status', $peminjaman->peminjaman_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" name="peminjaman_tglkembali" class="form-control" value="{{ $peminjaman->peminjaman_tglkembali ? \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->format('Y-m-d') : '' }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="denda" class="form-label">Denda</label>
                                <input type="number" name="peminjaman_denda" class="form-control" value="{{ $peminjaman->peminjaman_denda ?? 0 }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">Catatan</label>
                                <textarea name="peminjaman_note" class="form-control">{{ $peminjaman->peminjaman_note }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status Kembali</label>
                                <select name="peminjaman_statuskembali" class="form-control">
                                    <option value="1" {{ $peminjaman->peminjaman_statuskembali ? 'selected' : '' }}>Selesai</option>
                                    <option value="0" {{ !$peminjaman->peminjaman_statuskembali ? 'selected' : '' }}>Belum Selesai</option>
                                </select>
                            </div>
                            <div style="display: flex; gap:20px">
                            <button type="submit" class="btn btn-success mt-3">Update Status</button>
                            <a href="{{ route('peminjaman') }}" class="btn btn-secondary mt-3">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </main>
    </div>
</div>
@endsection
