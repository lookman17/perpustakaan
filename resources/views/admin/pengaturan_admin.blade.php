@php
    $user = Auth::user();
@endphp

@extends('template.layout')

@section('title', 'Halaman Pengaturan')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Pengaturan</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Halaman Pengaturan Akun</li>
                </ol>
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="d-flex items-center gap-4">
                    @if ($user->user_pict_url === '')
                        <img src="{{ asset('img/placeholder.png') }}" alt="..." class="rounded-circle img-profile img-thumbnail">
                    @else
                        <img src="{{ asset('storage/profile_pictures/'.basename($user->user_pict_url)) }}" alt="..." class="rounded-circle img-profile img-thumbnail">
                    @endif
                    {{-- Upload Profile Form --}}
                    <form action="{{ route('action.upload_profile', ['id' => $user->user_id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="profile" class="form-label">Upload Profile</label>
                            <input type="file" name="profile" id="profile" class="form-control">
                        </div>
                        <div class="form-group my-3">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
                <form action="" class="my-4 row gap-3">
                    <div class="form-group col-12 col-md-4">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label for="notelp" class="form-label">No Telp</label>
                        <input type="number" class="form-control" name="notelp" id="notelp">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <div class="form-group col-12 col-md-4">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
