@extends('template.layout')

@section('title', 'Edit Rak')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Rak</h1>
                <form action="{{ route('rak.update', $rak->rak_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="rak_nama">Nama Rak *</label>
                        <select name="rak_nama" class="form-control" required>
                            <option value="" disabled>Pilih Nama Rak</option>
                            @foreach($raks as $r)
                                <option value="{{ $r->rak_nama }}" {{ $rak->rak_nama == $r->rak_nama ? 'selected' : '' }}>
                                    {{ $r->rak_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rak_lokasi">Lokasi *</label>
                        <input type="text" name="rak_lokasi" class="form-control" value="{{ $rak->rak_lokasi }}" required>
                    </div>

                    <div class="form-group">
                        <label for="rak_kapasitas">Kapasitas *</label>
                        <select name="rak_kapasitas" class="form-control" required>
                            <option value="" disabled>Pilih Kapasitas</option>
                            <option value="10" {{ $rak->rak_kapasitas == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $rak->rak_kapasitas == 20 ? 'selected' : '' }}>20</option>
                            <option value="25" {{ $rak->rak_kapasitas == 25 ? 'selected' : '' }}>25</option>
                            <option value="30" {{ $rak->rak_kapasitas == 30 ? 'selected' : '' }}>30</option>
                            <option value="50" {{ $rak->rak_kapasitas == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Rak</button>
                    <a href="{{ route('rak.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
