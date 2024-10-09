@extends('template.layout')

@section('title', 'Tambah Buku - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>

            <div class="container-fluid px-4">
                <h1 class="mt-4">Tambah Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Tambah Buku</li>
                </ol>
                <form action="{{ route('action.create_buku') }}" method="POST" enctype="multipart/form-data"> <!-- Tambahkan enctype -->
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row gap-3">
                        <div class="col-12 col-md-4 form-group">
                            <label for="judul_buku" class="form-label">Judul Buku *</label>
                            <input type="text" name="judul_buku" id="judul_buku" class="form-control" placeholder="Masukkan judul buku" required>
                            @error('judul_buku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="penulis_id" class="form-label">Penulis Buku *</label>
                            <select name="penulis_id" id="penulis_id" class="form-control" required>
                                <option value="" disabled selected>-Pilih Penulis Buku-</option>
                                @foreach($penulis as $p)
                                    <option value="{{ $p->penulis_id }}">{{ $p->penulis_nama_id }}</option>
                                @endforeach
                            </select>
                            @error('penulis_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="penerbit_id" class="form-label">Penerbit Buku *</label>
                            <select name="penerbit_id" id="penerbit_id" class="form-control" required>
                                <option value="" disabled selected>-Pilih Penerbit Buku-</option>
                                @foreach($penerbit as $p)
                                    <option value="{{ $p->penerbit_id }}">{{ $p->penerbit_nama }}</option>
                                @endforeach
                            </select>
                            @error('penerbit_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit *</label>
                            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" placeholder="Masukkan tahun terbit" required>
                            @error('tahun_terbit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="kategori_id" class="form-label">Kategori Buku *</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="" disabled selected>-Pilih Kategori Buku-</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="rak_id" class="form-label">Rak Buku *</label>
                            <select name="rak_id" id="rak_id" class="form-control" required>
                                <option value="" disabled {{ old('rak_id') ? '' : 'selected' }}>-Pilih Rak Buku-</option>
                                @foreach($rak as $r)
                                    <option value="{{ $r->rak_id }}" {{ old('rak_id') == $r->rak_id ? 'selected' : '' }}>{{ $r->rak_nama }}</option>
                                @endforeach
                            </select>

                            @error('rak_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="isbn" class="form-label">Nomor ISBN *</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Masukkan nomor ISBN" required>
                            @error('isbn')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 col-md-4 form-group">
                            <label for="gambar_buku" class="form-label">Gambar Buku *</label>
                            <input type="file" name="buku_gambar" id="buku_gambar" class="form-control" accept="image/*" required>

                            @error('gambar_buku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-primary">Tambahkan</button>
                            <a href="{{ route('buku') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
