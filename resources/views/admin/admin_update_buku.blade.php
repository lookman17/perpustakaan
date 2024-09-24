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
                <form action="{{ route('buku.update', ['buku_id' => $buku->buku_id]) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku" id="judul_buku" class="form-control" value="{{ $buku->buku_judul }}" required>
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
                        <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" value="{{ $buku->buku_thnterbit }}" required>
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
                        <input type="text" name="isbn" id="isbn" class="form-control" value="{{ $buku->buku_isbn }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update Buku</button>
                    <a href="{{ route('buku') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
