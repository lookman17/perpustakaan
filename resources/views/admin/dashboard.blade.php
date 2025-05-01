
@extends('template.layout')

<?php
    $user = Auth::user();
?>

@section('title', 'Dashboard Admin')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 mb-3 fw-bolder text-primary">Dashboard Admin</h1>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-light rounded-3 p-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-primary fw-medium"><i class="bi bi-house-door-fill me-1"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>

                <p class="h5 mb-4 text-muted">Selamat datang kembali, <span class="fw-semibold">{{ $user->name ?? 'Admin' }}</span>!</p>

                <div class="row mb-4">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                            <div class="card-body text-white d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-people-fill display-4 opacity-75"></i>
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <h5 class="card-title mb-1 text-uppercase fs-6 fw-light">Jumlah Pengguna</h5>
                                    <h2 class="fw-bold display-6">{{ $jumlahPengguna ?? 0 }}</h2>
                                </div>
                            </div>
                            <a href="#" class="card-footer bg-transparent border-top-0 text-end text-white-50 text-decoration-none small py-2">
                                Lihat Detail <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Card Jumlah Stok Buku --}}
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100" style="background: linear-gradient(135deg, #28a745 0%, #1c7430 100%);">
                            <div class="card-body text-white d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-stack display-4 opacity-75"></i> {{-- Icon yang mungkin lebih relevan untuk stok --}}
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <h5 class="card-title mb-1 text-uppercase fs-6 fw-light">Total Stok Buku</h5>
                                    <h2 class="fw-bold display-6">{{ $jumlahStok ?? 0 }}</h2>
                                </div>
                            </div>
                             <a href="#" class="card-footer bg-transparent border-top-0 text-end text-white-50 text-decoration-none small py-2">
                                Lihat Detail <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Card Jumlah Judul Buku --}}
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100" style="background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);">
                            <div class="card-body text-white d-flex align-items-center p-4">
                                <div class="flex-shrink-0 me-3">
                                    <i class="bi bi-book-half display-4 opacity-75"></i> {{-- Icon yang mungkin lebih relevan untuk judul --}}
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <h5 class="card-title mb-1 text-uppercase fs-6 fw-light">Jumlah Judul Buku</h5>
                                    <h2 class="fw-bold display-6">{{ $jumlahJudul ?? 0 }}</h2>
                                </div>
                            </div>
                             <a href="#" class="card-footer bg-transparent border-top-0 text-end text-white-50 text-decoration-none small py-2">
                                Lihat Detail <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Grafik Pie Kategori --}}
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card shadow-sm border-light rounded-3">
                             <div class="card-header bg-white border-bottom-0 py-3">
                                <h5 class="fw-bold text-primary mb-0"><i class="bi bi-pie-chart-fill me-2"></i>Jumlah Buku yang Berkategori</h5>
                            </div>
                            <div class="card-body p-4 d-flex justify-content-center align-items-center" style="min-height: 400px;">
                                {{-- Pastikan data $bukuKategori ada dan tidak kosong --}}
                                @if(isset($bukuKategori) && $bukuKategori->count() > 0)
                                    <div style="position: relative; height:350px; width:100%; max-width: 450px;"> {{-- Wrapper untuk kontrol ukuran --}}
                                        <canvas id="kategoriChart"></canvas>
                                    </div>
                                @else
                                    <div class="alert alert-warning text-center" role="alert">
                                      <i class="bi bi-exclamation-triangle-fill me-2"></i> Data kategori buku tidak ditemukan atau kosong.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div> {{-- End Container Fluid --}}
        </main>

        {{-- Pastikan footer sudah di-include dengan benar --}}
        @include('template.footer')
    </div> {{-- End layoutSidenav_content --}}
</div> {{-- End layoutSidenav --}}

{{-- Script untuk Chart.js (jika ada data) --}}
@if(isset($bukuKategori) && $bukuKategori->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script> {{-- Versi Chart.js yg lebih baru --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxKategori = document.getElementById('kategoriChart')?.getContext('2d'); // Tambah ? untuk safety check
        if (ctxKategori) {
            const kategoriChart = new Chart(ctxKategori, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($bukuKategori->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($bukuKategori->values()) !!},
                        backgroundColor: [ // Palet warna lebih bervariasi
                            '#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1',
                            '#fd7e14', '#20c997', '#6610f2', '#e83e8c', '#17a2b8'
                            // Tambahkan lebih banyak warna jika kategori > 10
                        ],
                        borderColor: '#ffffff', // Garis batas antar slice
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // Penting agar ukuran bisa diatur oleh container
                    plugins: {
                        legend: {
                            position: 'bottom', // Posisi legenda
                            labels: {
                                padding: 20, // Jarak antar item legenda
                                usePointStyle: true, // Gunakan style titik
                                boxWidth: 10 // Ukuran kotak/titik legenda
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.7)', // Background tooltip
                            titleFont: { weight: 'bold' },
                            bodyFont: { size: 14 },
                            padding: 10, // Padding dalam tooltip
                            cornerRadius: 4, // Sudut tooltip
                            displayColors: false, // Sembunyikan kotak warna di tooltip
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Ambil label dan value dari tooltip item
                                    let label = tooltipItem.label || '';
                                    let value = tooltipItem.raw || 0;
                                    // Hitung total
                                    let total = tooltipItem.chart.getDatasetMeta(0).total || 1; // hindari pembagian dengan 0
                                    // Hitung persentase
                                    let percentage = ((value / total) * 100).toFixed(1);

                                    if (label) {
                                        label += ': ';
                                    }
                                    // Format output tooltip
                                    return `${label}${value} Buku (${percentage}%)`;
                                }
                            }
                        }
                    },
                    layout: {
                        padding: 10 // Padding di sekitar chart
                    }
                }
            });
        } else {
            console.error("Canvas element with id 'kategoriChart' not found.");
        }
    });
</script>
@endif

@endsection

