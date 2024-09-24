@extends('template.layout')

@section('title', 'Edit Peminjaman')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Peminjaman</h1>
                <form action="{{ route('peminjaman.update', $peminjaman->peminjaman_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="user_id">User ID *</label>
                        <input type="text" name="user_id" class="form-control" value="{{ $peminjaman->peminjaman_user_id }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_peminjaman">Tanggal Peminjaman *</label>
                        <input type="date" name="tanggal_peminjaman" class="form-control" value="{{ $peminjaman->peminjaman_tglpinjam }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_kembali">Tanggal Kembali *</label>
                        <input type="date" name="tanggal_kembali" class="form-control" value="{{ $peminjaman->peminjaman_tglkembali }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="buku_ids">Buku yang Dipinjam *</label>
                        <select name="buku_ids[]" class="form-control" multiple required>
                            @foreach ($bukus as $buku)
                                <option value="{{ $buku->buku_id }}"
                                    {{ $peminjaman->details->contains('peminjaman_detail_buku_id', $buku->buku_id) ? 'selected' : '' }}>
                                    {{ $buku->buku_judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="denda">Denda (jika ada)</label>
                        <input type="number" name="denda" class="form-control" min="0" placeholder="Masukkan denda" value="{{ $peminjaman->peminjaman_denda }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Status Peminjaman</button>
                    <a href="{{ route('peminjaman') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
