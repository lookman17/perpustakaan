@extends('template.layout')

@section('title', 'Daftar Rak')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Rak</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Rak</li>
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

                <a href="{{ route('rak.create') }}" class="btn btn-primary mb-3">Tambah Rak</a>

                <div class="table-responsive card bg-light">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>ID Rak</th>
                                <th>Nama</th>
                                <th>Lokasi</th>
                                <th>Kapasitas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($raks as $rak)
                                <tr>
                                    <td>{{ $rak->rak_id }}</td>
                                    <td>{{ $rak->rak_nama }}</td>
                                    <td>{{ $rak->rak_lokasi }}</td>
                                    <td>{{ $rak->rak_kapasitas }}</td>
                                    <td>
                                        <a href="{{ route('rak.edit', $rak->rak_id) }}" class="btn btn-warning"><i class="fas fa-pencil"></i></a>
                                        <form action="{{ route('rak.destroy', $rak->rak_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rak ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
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
