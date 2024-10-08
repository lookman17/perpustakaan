@extends('template.layout')

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
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Data Buku</li>
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
                <a href="{{ route('create_buku') }}">
                    <button class="btn btn-primary my-3">Tambah Buku</button>
                </a>

                <div class="table-responsive card bg-light">
                    <table class="table table-bordered">
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
                                <td>{{ $buku->rak->rak_lokasi }}({{ $buku->rak->rak_nama }})</td>
                                <td>
                                    <button class="btn btn-primary btn-detail"
                                            data-judul="{{ $buku->buku_judul }}"
                                            data-penulis="{{ $buku->penulis->penulis_nama_id }}"
                                            data-penerbit="{{ $buku->penerbit->penerbit_nama }}"
                                            data-tahun="{{ $buku->buku_thnterbit }}"
                                            data-kategori="{{ $buku->kategori->kategori_nama }}"
                                            data-rak="{{ $buku->rak->rak_lokasi }}({{ $buku->rak->rak_nama }})"
                                            data-isbn="{{ $buku->buku_isbn }}">
                                        Lihat Detail
                                    </button>
                                    <a href="{{ route('update_buku', ['buku_id' => $buku->buku_id]) }}">
                                        <button class="btn btn-warning"><i class="fas fa-pencil"></i></button>
                                    </a>
                                    <form action="{{ route('buku.delete', ['buku_id' => $buku->buku_id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $bukus->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalDetailContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const detailButtons = document.querySelectorAll('.btn-detail');

        detailButtons.forEach(button => {
            button.addEventListener('click', function() {

                const judul = this.getAttribute('data-judul');
                const penulis = this.getAttribute('data-penulis');
                const penerbit = this.getAttribute('data-penerbit');
                const tahun = this.getAttribute('data-tahun');
                const kategori = this.getAttribute('data-kategori');
                const rak = this.getAttribute('data-rak');
                const isbn = this.getAttribute('data-isbn');

                const modalContent = `
                    <strong>Judul Buku:</strong> ${judul}<br>
                    <strong>Penulis:</strong> ${penulis}<br>
                    <strong>Penerbit:</strong> ${penerbit}<br>
                    <strong>Tahun Terbit:</strong> ${tahun}<br>
                    <strong>Kategori:</strong> ${kategori}<br>
                    <strong>Rak:</strong> ${rak}<br>
                    <strong>ISBN:</strong> ${isbn}
                `;

                document.getElementById('modalDetailContent').innerHTML = modalContent;

                var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
                myModal.show();
            });
        });
    });
</script>
@endsection
