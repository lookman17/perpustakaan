@extends('template.layout')
@php
    $user = Auth::user();
@endphp
@section('title', 'Daftar Peminjaman')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Peminjaman</h1>
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb bg-light rounded-3 p-3 shadow-sm">
                        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-primary fw-medium"></i>Peminjaman</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola</li>
                    </ol>
                </nav>
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
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>
                <!-- Form Filter Periode untuk Cetak Laporan -->
                <form action="{{ route('peminjaman.laporan') }}" method="GET" class="mb-3 d-flex gap-2 align-items-end">
                    <div>
                        <label for="periode" class="form-label">Periode</label>
                        <select name="periode" id="periode" class="form-control" onchange="toggleDateFields()">
                            <option value="">Pilih Periode</option>
                            <option value="semua" {{ request('periode') == 'semua' ? 'selected' : '' }}>Semua History Peminjaman</option>
                            <option value="range" {{ request('periode') == 'range' ? 'selected' : '' }}>Rentang Tanggal</option>
                        </select>
                    </div>
                
                    <div id="start_date_div" style="{{ request('periode') == 'range' ? '' : 'display:none;' }}">
                        <label for="start_date" class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                
                    <div id="end_date_div" style="{{ request('periode') == 'range' ? '' : 'display:none;' }}">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                
                    <div>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </form>
                

                <!-- Form Pencarian -->
                <form action="{{ route('peminjaman.search') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari Nama Pengguna atau Judul Buku..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
                

                <div class="table-responsive card bg-light">
                    <table class="table table-bordered">
                        <thead class="table ">
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Kembali</th>
                                <th>Status Kembali</th>
                                <th>Detail Buku</th>
                                <th>Aksi</th>
                                <th>Cetak Pdf</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->user->user_nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam)->format('d-m-Y') }}</td>
                                    <td>{{ $peminjaman->peminjaman_tglkembali ? \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->format('d-m-Y') : 'Belum Kembali' }}</td>
                                    <td>
                                        @if ($peminjaman->peminjaman_statuskembali)
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning">Masih Dipinjam</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($peminjaman->details as $detail)
                                            {{ $detail->buku->buku_judul }}<br>
                                        @endforeach
                                    </td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('peminjaman.status', $peminjaman->peminjaman_id) }}" class="btn btn-warning text-white">Status</a>
                        
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $peminjaman->peminjaman_id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{ route('peminjaman.cetak', $peminjaman->peminjaman_id) }}" class="btn btn-info" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                        
                                <!-- Modal Hapus -->
                                <div class="modal fade" id="hapusModal{{ $peminjaman->peminjaman_id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $peminjaman->peminjaman_id }}" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <form action="{{ route('peminjaman.destroy', $peminjaman->peminjaman_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="hapusModalLabel{{ $peminjaman->peminjaman_id }}">Konfirmasi Hapus</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center text-warning mb-3">
                                                <i class="fas fa-exclamation-triangle fa-3x"></i>
                                            </div>
                                            Apakah Anda yakin ingin menghapus peminjaman oleh <strong>{{ $peminjaman->user->user_nama }}</strong>?
                                        </div>
                                        
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                          <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                        
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                        
                    </table>
                </div>
                <br>
                {{ $peminjamans->links('vendor.pagination.bootstrap-5') }}
            </div>
        
        </main>
        <br>
        @include('template.footer')
    </div>
</div>

<script>
    function toggleDateFields() {
        var periode = document.getElementById('periode').value;
        var startDateDiv = document.getElementById('start_date_div');
        var endDateDiv = document.getElementById('end_date_div');

        if (periode == 'range') {
            startDateDiv.style.display = 'block';
            endDateDiv.style.display = 'block';
        } else {
            startDateDiv.style.display = 'none';
            endDateDiv.style.display = 'none';
        }
    }
</script>

@endsection

{{-- @extends('template.layout')

@php
    // Ambil user yang sedang login
    $user = Auth::user();
    // Definisikan durasi pinjam default (misal: 7 hari). Sebaiknya diambil dari konfigurasi.
    $durasiPinjamHari = 7;
@endphp

@section('title', 'Daftar Peminjaman')

@section('header')
    @include('template.navbar_admin')
@endsection

@section('main')
<div id="layoutSidenav">
    @include('template.sidebar_admin') 

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4 fw-bolder">Daftar Peminjaman</h1>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-4 shadow-sm bg-light p-3 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('dashboardAdmin') }}" class="text-decoration-none"><i class="bi bi-house-door-fill me-1"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Peminjaman</li>
                  </ol>
                </nav>

                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif (session('deleted'))
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
                     <i class="bi bi-info-circle-fill me-2"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('deleted') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <div class="d-flex justify-content-between align-items-center">
                             <h5 class="card-title mb-0 fw-medium"><i class="bi bi-list-ul me-2"></i>Data Peminjaman Buku</h5>
                             <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">
                                 <i class="bi bi-plus-lg me-1"></i> Tambah Peminjaman
                             </a>
                        </div>
                        <form action="{{ route('peminjaman.search') }}" method="GET" class="mt-3">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Cari ID Pinjam, Nama Peminjam, atau Judul Buku..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit" title="Cari Data"><i class="bi bi-search"></i></button>
                                @if(request('search'))
                                    <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian"><i class="bi bi-arrow-clockwise"></i></a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="card-body p-0"> 
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered mb-0 align-middle"> 
                                <thead class="table-primary text-nowrap">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>ID Pinjam</th>
                                        <th>Peminjam</th>
                                        <th>Tgl Pinjam</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tgl Kembali</th>
                                        <th class="text-center">Status</th>
                                        <th>Detail Buku</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($peminjamans as $index => $peminjaman)
                                        @php
                                            $tglPinjam = \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam);
                                            $tglJatuhTempo = $tglPinjam->copy()->addDays($durasiPinjamHari);
                                            $isOverdue = !$peminjaman->peminjaman_statuskembali && \Carbon\Carbon::now()->gt($tglJatuhTempo);
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $peminjamans->firstItem() + $index }}</td>
                                            <td>{{ $peminjaman->peminjaman_id }}</td>
                                            <td>{{ $peminjaman->user->user_nama ?? 'N/A' }}</td>
                                            <td class="text-nowrap">{{ $tglPinjam->format('d M Y') }}</td>
                                            <td class="text-nowrap">{{ $tglJatuhTempo->format('d M Y') }}</td>
                                            <td class="text-nowrap">
                                                {{ $peminjaman->peminjaman_tglkembali ? \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->format('d M Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($peminjaman->peminjaman_statuskembali)
                                                    <span class="badge bg-success rounded-pill px-3 py-1">Selesai</span>
                                                @elseif ($isOverdue)
                                                     <span class="badge bg-danger rounded-pill px-3 py-1">Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-1">Dipinjam</span>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-unstyled mb-0" style="font-size: 0.9em;">
                                                    @foreach ($peminjaman->details as $detail)
                                                        <li><i class="bi bi-book me-1"></i>{{ $detail->buku->buku_judul ?? 'N/A' }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="text-center text-nowrap">
                                                <a href="{{ route('peminjaman.status', $peminjaman->peminjaman_id) }}" class="btn btn-outline-info btn-sm me-1" data-bs-toggle="tooltip" data-bs-title="Ubah Status / Detail">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="{{ route('peminjaman.cetak', $peminjaman->peminjaman_id) }}" class="btn btn-outline-secondary btn-sm me-1" target="_blank" data-bs-toggle="tooltip" data-bs-title="Cetak Struk">
                                                    <i class="bi bi-printer-fill"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $peminjaman->peminjaman_id }}" data-bs-toggle="tooltip" data-bs-title="Hapus Peminjaman">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="hapusModal{{ $peminjaman->peminjaman_id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $peminjaman->peminjaman_id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('peminjaman.destroy', $peminjaman->peminjaman_id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="hapusModalLabel{{ $peminjaman->peminjaman_id }}"><i class="bi bi-trash3-fill me-2"></i>Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-center mb-3">
                                                                <i class="bi bi-exclamation-triangle-fill text-warning display-4"></i>
                                                            </div>
                                                            Apakah Anda yakin ingin menghapus data peminjaman dengan ID
                                                            <strong>#{{ $peminjaman->peminjaman_id }}</strong>
                                                            oleh <strong>{{ $peminjaman->user->user_nama ?? 'N/A' }}</strong>?
                                                            <br><small class="text-muted">Tindakan ini tidak dapat diurungkan.</small>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5 text-muted">
                                                <i class="bi bi-x-circle fs-3 d-block mb-2"></i>
                                                Data tidak ditemukan.
                                                @if(request('search'))
                                                    <br><small>Tidak ada data yang cocok dengan pencarian "{{ request('search') }}". <a href="{{ route('peminjaman.index') }}">Tampilkan semua data</a>.</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 

                
                <div class="d-flex justify-content-center">
                    {{ $peminjamans->links('vendor.pagination.bootstrap-5') }}
                </div>

            </div>
        </main>

        @include('template.footer') 
    </div>
</div> 

@endsection

@push('scripts') 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush --}}