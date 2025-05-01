<!DOCTYPE html>
@php
    \Carbon\Carbon::setLocale('id'); // Mengatur bahasa Indonesia untuk Carbon
@endphp

<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .report-container {
            padding: 20px;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        .report-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 15px;
        }

        .report-header h2 {
            margin: 0;
            font-size: 18px;
            color: #0056b3;
        }

        .report-header p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        .report-section {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #eee;
        }

        h4 {
            margin-top: 0;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .detail-item {
            margin-bottom: 6px;
        }

        .detail-item strong {
            display: inline-block;
            width: 130px;
            color: #444;
            font-weight: bold;
        }

        .detail-item span {
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
            background-color: #f8f8f8;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #f0f0f0;
        }

        .denda {
            font-weight: bold;
            color: #dc3545;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    @php
        $durasiPinjamHari = $peminjaman->durasi_pinjam ?? 7;
        $tglPinjam = \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam);
        $tglJatuhTempo = $tglPinjam->copy()->addDays($durasiPinjamHari);
        $statusText = 'Dipinjam';
        $statusClass = 'status-dipinjam';
        if ($peminjaman->peminjaman_statuskembali) {
            $statusText = 'Sudah Kembali';
            $statusClass = 'status-kembali';
        } elseif (\Carbon\Carbon::now()->gt($tglJatuhTempo)) {
            $statusText = 'Terlambat';
            $statusClass = 'status-terlambat';
        }

        $dendaFinal = $peminjaman->denda_terhitung ?? $peminjaman->peminjaman_denda ?? 0;
    @endphp

    <div class="report-container">
        <div class="report-header">
            <h2>Laporan Peminjaman Buku</h2>
            <p>Perpustakaan SMKN6 Malang</p>
            <p>Alamat : Jalan Ki Ageng Gribig No. 28 Madyopuro, Kota Malang 65139</p>
            <p>Telepon: (0341) 123456 | Email: perpus@smkn6malang.sch.id</p>
        </div>

        <div class="report-section">
            <h4>Informasi Peminjaman</h4>
            <div class="detail-item">
                <strong>Tanggal Pinjam:</strong> 
                <span>{{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglpinjam)->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
            
            @if($peminjaman->peminjaman_tglkembali)
                <div class="detail-item">
                    <strong>Tanggal Kembali:</strong>
                    <span>{{ \Carbon\Carbon::parse($peminjaman->peminjaman_tglkembali)->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
            @else
                <div class="detail-item">
                    <strong>Tanggal Kembali:</strong>
                    <span>- Belum Dikembalikan -</span>
                </div>
            @endif
            
        </div>

        <div class="report-section">
            <h4>Daftar Buku yang Dipinjam</h4>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul Buku</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman->details as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}.</td>
                            <td>{{ $detail->buku->buku_judul ?? 'Judul Tidak Tersedia' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" style="text-align: center; color: #888; padding: 15px;"><i>Tidak ada buku dalam peminjaman ini.</i></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($peminjaman->peminjaman_statuskembali || $dendaFinal > 0)
        <div class="report-section">
            <h4>Ringkasan Pengembalian & Denda</h4>
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
                <span class="denda">Rp{{ number_format($dendaFinal, 0, ',', '.') }}</span>
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
