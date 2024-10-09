@extends('template.layout')

@section('title', 'Update Buku - Admin Perpustakaan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Update Buku</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Update Data Buku</li>
                </ol>

                <!-- Menampilkan Pesan Kesalahan -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('buku.update', ['buku_id' => $buku->buku_id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="{{ $buku->buku_judul }}" placeholder="Masukkan Judul Buku" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="penulis_id" class="form-label">Penulis Buku</label>
                        <select name="penulis_id" id="penulis_id" class="form-control" required>
                            <option value="" disabled>Pilih Penulis Buku</option>
                            @foreach($penulis as $p)
                                <option value="{{ $p->penulis_id }}" {{ $p->penulis_id == $buku->buku_penulis_id ? 'selected' : '' }}>
                                    {{ $p->penulis_nama_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="penerbit_id" class="form-label">Penerbit Buku</label>
                        <select name="penerbit_id" id="penerbit_id" class="form-control" required>
                            <option value="" disabled>Pilih Penerbit Buku</option>
                            @foreach($penerbit as $p)
                                <option value="{{ $p->penerbit_id }}" {{ $p->penerbit_id == $buku->buku_penerbit_id ? 'selected' : '' }}>
                                    {{ $p->penerbit_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" value="{{ $buku->buku_thnterbit }}" placeholder="Masukkan Tahun Terbit" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="kategori_id" class="form-label">Kategori Buku</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="" disabled>Pilih Kategori Buku</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->kategori_id }}" {{ $k->kategori_id == $buku->buku_kategori_id ? 'selected' : '' }}>
                                    {{ $k->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="rak_id" class="form-label">Rak Buku</label>
                        <select name="rak_id" id="rak_id" class="form-control" required>
                            <option value="" disabled>Pilih Rak Buku</option>
                            @foreach($rak as $r)
                                <option value="{{ $r->rak_id }}" {{ $r->rak_id == $buku->buku_rak_id ? 'selected' : '' }}>
                                    {{ $r->rak_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" name="isbn" id="isbn" class="form-control" value="{{ $buku->buku_isbn }}" placeholder="Masukkan ISBN Buku" required>
                    </div>

                    <!-- Input untuk Unggah Gambar Buku -->
                    <div class="form-group mb-3">
                        <label for="gambar" class="form-label">Gambar Buku</label>
                        <input type="file" name="buku_gambar" id="buku_gambar" class="form-control" accept="image/*">
                        @if($buku->buku_gambar)
                            <img src="{{ asset('storage/img/buku' . basename($buku->buku_gambar)) }}" alt="Gambar Buku" class="mt-2" style="max-width: 150px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Update Buku</button>
                    <a href="{{ route('buku') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
