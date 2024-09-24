@extends('template.layout')

@section('title', 'Pengaturan - Admin Perpustakaan')

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
                            <li class="breadcrumb-item active">Halaman Pengaturan Admin dan Siswa Perpustakaan</li>
                        </ol>
                        <table class="table table-bordered">
                            <thead class="table table-dark">
                                <tr>
                                    <th>Keterangan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tr>
                                <th>Nama</th>
                                <td><input type="text" placeholder="Masukan Nama" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td><input type="text" placeholder="Masukan Username" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><input type="text" placeholder="Masukan Alamat" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><input type="email" placeholder="Masukan Email" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>No Hp</th>
                                <td><input type="number" placeholder="Masukan No Hp" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td><input type="text" placeholder="Masukan Password" class="form-control"></td>
                            </tr>   
                        </table>
                        <div class="row my-3">
                            <div class="col-12 col-md-4">
                                <button class="btn btn-primary">Update Data User</button>
                            </div>
                            @endsection