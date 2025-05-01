<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    {{-- Judul bisa lebih deskriptif untuk laporan --}}
    <title>Laporan Peminjaman - ID {{ $peminjaman->peminjaman_id ?? 'N/A' }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0; /* Latar belakang sedikit lebih terang */
            padding: 30px; /* Padding lebih banyak di body */
            font-size: 14px; /* Ukuran font dasar sedikit lebih besar */
            color: #333;
            line-height: 1.6; /* Spasi baris lebih lega */
        }

        .report-container {
            background: white;
            padding: 35px; /* Padding internal lebih besar */
            border: 1px solid #ccc; /* Border solid */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Shadow lebih jelas */
            width: 750px; /* Lebar lebih besar, cocok untuk laporan */
            margin: 30px auto; /* Margin atas/bawah lebih besar */
            text-align: left;
        }

        .report-header {
            text-align: center;
            margin-bottom: 30px; /* Jarak lebih besar di bawah header */
            border-bottom: 2px solid #0056b3; /* Garis solid tebal di bawah header */
            padding-bottom: 20px;
        }

        .report-header h1 { /* Menggunakan H1 untuk judul utama laporan */
            margin: 0 0 8px 0;
            font-size: 1.8em; /* Ukuran judul lebih besar */
            color: #0056b3; /* Warna biru konsisten */
        }
         .report-header h2 { /* Subjudul untuk nama institusi */
             margin: 0 0 5px 0;
             font-size: 1.3em;
             color: #333;
             font-weight: normal; /* Tidak terlalu tebal */
         }
         .report-header p {
            margin: 0;
            font-size: 0.95em;
            color: #555;
         }

        .report-section {
            margin-bottom: 25px; /* Jarak antar seksi */
            padding-bottom: 25px;
            border-bottom: 1px solid #e0e0e0; /* Pemisah antar seksi solid halus */
        }
        .report-section:last-child {
             margin-bottom: 0;
             padding-bottom: 0;
             border-bottom: none;
        }


        h3 { /* Menggunakan H3 untuk subjudul seksi */
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.2em;
            color: #333;
            border-bottom: 1px solid #ccc; /* Garis bawah solid untuk subjudul */
            padding-bottom: 8px;
        }

        .detail-item {
            margin-bottom: 8px; /* Jarak antar item detail */
            display: flex; /* Gunakan flexbox untuk alignment */
            align-items: baseline;
        }

        .detail-item strong {
            display: inline-block;
            width: 150px; /* Lebar label sedikit lebih besar */
            color: #444;
            font-weight: 600; /* Sedikit lebih tebal */
            flex-shrink: 0; /* Agar label tidak menyusut */
        }
        .detail-item span {
             flex-grow: 1; /* Agar nilai mengisi sisa ruang */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 1em; /* Ukuran font tabel standar */
        }

        th {
            text-align: left;
            padding: 10px 8px; /* Padding lebih nyaman */
            border-bottom: 2px solid #999; /* Garis bawah header tabel lebih tebal */
            background-color: #f8f8f8;
            color: #333;
            font-weight: 600;
        }
        td {
            padding: 10px 8px; /* Padding konsisten */
            border-bottom: 1px solid #eee; /* Garis bawah solid tipis antar baris */
            vertical-align: top;
        }
        tbody tr:last-child td {
            border-bottom: none;
        }
        /* Penomoran rata kanan di tabel */
        td:first-child, th:first-child {
            width: 40px;
            text-align: right;
            padding-right: 15px;
        }
         /* Kolom judul buku bisa lebih lebar */
         td:nth-child(2), th:nth-child(2) {
             width: auto; /* Biarkan mengisi sisa */
         }


        .summary-section { /* Ubah nama kelas agar lebih sesuai */
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0; /* Garis atas solid */
        }

        .denda {
            font-weight: bold;
            color: #dc3545;
            font-size: 1.1em;
        }

        .footer-note {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ccc; /* Garis pemisah solid sebelum footer */
            font-size: 0.9em;
            color: #777;
        }

         /* Helper class */
         .text-bold {
             font-weight: bold;
         }
         .status-terlambat {
             color: #dc3545;
             font-weight: bold;
         }
         .status-kembali {
             color: #28a745;
             font-weight: bold;
         }
         .status-dipinjam {
              color: #007bff;
              font-weight: bold;
         }
    </style>
</head>
<body>
    {{-- Asumsi $peminjaman sudah di-pass dari Controller --}}
    @php
        // Hitung Tanggal Jatuh Tempo (Asumsi durasi pinjam 7 hari, sesuaikan jika perlu)
        $durasiPinjamHari = $peminjaman->durasi_pinjam ?? 7; // Ambil dari setting atau DB jika ada
        $tglPinjam = \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam);
        $tglJatuhTempo = $tglPinjam->copy()->addDays($durasiPinjamHari);

        // Tentukan status lebih deskriptif dan kelas CSSnya
        $statusText = 'Dipinjam';
        $statusClass = 'status-dipinjam';
        if ($peminjaman->peminjaman_statuskembali) {
            $statusText = 'Sudah Kembali';
            $statusClass = 'status-kembali';
        } elseif (\Carbon\Carbon::now()->gt($tglJatuhTempo)) {
            $statusText = 'Terlambat';
            $statusClass = 'status-terlambat';
        }

        // Ambil nilai denda yang relevan
        $dendaFinal = $peminjaman->denda_terhitung ?? $peminjaman->peminjaman_denda ?? 0;

    @endphp

    <div class="report-container">
        <div class="report-header">
            {{-- Bisa ditambahkan logo di sini jika ada --}}
            {{-- <img src="/path/to/logo.png" alt="Logo Perpustakaan" style="height: 50px; margin-bottom: 15px;"> --}}
            <h1>Laporan Peminjaman Buku</h1>
            <h2>Perpustakaan SMKN6 Malang</h2>
            <p>Alamat : Jalan Ki Ageng Gribig No. 28 Madyopuro, Kota Malang 65139</p>
            <p>Telepon: (0341) 123456 | Email: perpus@smkn6malang.sch.id</p> {{-- Contoh tambahan info kontak --}}
        </div>

        <div class="report-section">
            <h3>Informasi Peminjaman</h3>
            <div class="detail-item"><strong>ID Peminjaman:</strong> <span>{{ $peminjaman->peminjaman_id ?? 'N/A' }}</span></div>
            <div class="detail-item"><strong>Nama Peminjam:</strong> <span>{{ $peminjaman->user->user_nama ?? 'N/A' }}</span></div>
             {{-- Tambahkan detail lain jika perlu, misal: Kelas, NIS/NIP --}}
             {{-- <div class="detail-item"><strong>Kelas/Jabatan:</strong> <span>{{ $peminjaman->user->kelas ?? 'N/A' }}</span></div> --}}
            <div class="detail-item"><strong>Tanggal Pinjam:</strong> <span>{{ $tglPinjam->isoFormat('dddd, D MMMM Y') }}</span></div> {{-- Format tanggal lebih lengkap --}}
            <div class="detail-item"><strong>Tanggal Jatuh Tempo:</strong> <span>{{ $tglJatuhTempo->isoFormat('dddd, D MMMM Y') }}</span></div>
            <div class="detail-item"><strong>Status Peminjaman:</strong> <span class="{{ $statusClass }}">{{ $statusText }}</span></div>
        </div>

        <div class="report-section">
            <h3>Daftar Buku yang Dipinjam</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul Buku</th>
                        {{-- Bisa tambah kolom lain jika relevan, misal: Kode Buku --}}
                        {{-- <th>Kode Buku</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}.</td>
                            <td>{{ $detail->buku->buku_judul ?? 'Judul Tidak Tersedia' }}</td>
                            {{-- <td>{{ $detail->buku->buku_kode ?? '-' }}</td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: #888; padding: 15px;"><i>Tidak ada buku dalam peminjaman ini.</i></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tampilkan bagian ini hanya jika sudah ada proses pengembalian atau denda --}}
        @if ($peminjaman->peminjaman_statuskembali || $dendaFinal > 0)
        <div class="report-section summary-section">
             <h3>Ringkasan Pengembalian & Denda</h3>
             @if($peminjaman->peminjaman_tglkembali)
             <div class="detail-item">
                 <strong>Tanggal Kembali:</strong>
                 <span>{{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->isoFormat('dddd, D MMMM Y') }}</span>
             </div>
             @else
              <div class="detail-item">
                 <strong>Tanggal Kembali:</strong>
                 <span>- Belum Dikembalikan -</span>
             </div>
             @endif
             <div class="detail-item">
                 <strong>Total Denda:</strong>
                 <span class="denda">
                     Rp{{ number_format($dendaFinal, 0, ',', '.') }}
                 </span>
                 {{-- Tambahkan detail perhitungan denda jika perlu --}}
                 {{-- @if($peminjaman->hari_terlambat > 0)
                 <span style="font-size: 0.9em; color: #666; margin-left: 10px;">({{ $peminjaman->hari_terlambat }} hari terlambat x Rp{{ number_format($peminjaman->denda_per_hari, 0, ',', '.') }})</span>
                 @endif --}}
            </div>
             <div class="detail-item">
                 <strong>Catatan:</strong>
                 <span>{{ $peminjaman->peminjaman_note ?? '-' }}</span>
             </div>
        </div>
        @endif

        <div class="footer-note">
            <p>Laporan ini dicetak pada: {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y, HH:mm:ss') }}</p>
            <p>© {{ date('Y') }} Perpustakaan SMKN6 Malang. Semua Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>