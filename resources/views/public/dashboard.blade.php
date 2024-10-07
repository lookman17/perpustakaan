@extends('template.layout')
@section('title', 'Dashboard siswa- Siswa Perpustakaan')

@section('header')
    @include('template.navbar_siswa')
@endsection
@section('main')
    <div id="layoutSidenav">
        @include('template.sidebar_siswa')
        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard Siswa</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Halaman Dashboard Siswa</li>
                        </ol>
                    </div>
@endsection
