@extends('template.layout')
@php
    $user = Auth::user();
@endphp
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

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Detail Peminjaman</strong>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pengguna</label>
                            <div class="form-control-plaintext">{{ $peminjaman->user->user_nama }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Peminjaman</label>
                            <div class="form-control-plaintext">
                                {{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam)->format('d-m-Y') }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Denda</label>
                            <div class="form-control-plaintext">
                                Rp {{ number_format($peminjaman->peminjaman_denda, 2, ',', '.') }}
                            </div>
                        </div>

                        <form action="{{ route('peminjaman.update-status', $peminjaman->peminjaman_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                    <input type="date" name="peminjaman_tglkembali" class="form-control"
                                        value="{{ $peminjaman->peminjaman_tglkembali ? \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->format('Y-m-d') : '' }}"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="denda" class="form-label">Denda</label>
                                    <input type="number" name="peminjaman_denda" class="form-control"
                                        value="{{ $peminjaman->peminjaman_denda ?? 0 }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="note" class="form-label">Catatan</label>
                                <textarea name="peminjaman_note" class="form-control" rows="3">{{ $peminjaman->peminjaman_note }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status Kembali</label>
                                <select name="peminjaman_statuskembali" class="form-select">
                                    <option value="1" {{ $peminjaman->peminjaman_statuskembali ? 'selected' : '' }}>Selesai</option>
                                    <option value="0" {{ !$peminjaman->peminjaman_statuskembali ? 'selected' : '' }}>Belum Selesai</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Update Status
                                </button>
                                <a href="{{ route('peminjaman') }}" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        @include('template.footer')
    </div>
</div>
@endsection
