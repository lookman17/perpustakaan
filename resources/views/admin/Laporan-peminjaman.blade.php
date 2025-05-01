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
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th, td {
            padding: 6px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        th {
            background-color: #f8f8f8;
            font-weight: bold;
            text-align: left;
        }

        .footer-note {
            text-align: center;
            margin-top: 20px;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="report-container">
        <div class="report-header">
            <h2>Laporan Peminjaman Buku</h2>
            <p>Perpustakaan SMKN6 Malang</p>
            <p>Alamat : Jalan Ki Ageng Gribig No. 28 Madyopuro, Kota Malang 65139</p>
            <p>Telepon: (0341) 123456 | Email: perpus@smkn6malang.sch.id</p>
        </div>

        <div class="report-section">
            <h4>Informasi Peminjaman</h4>
            <div class="detail-item"><strong>Periode:</strong> {{ $periode }}</div>
            <div class="detail-item"><strong>Total Peminjaman:</strong> {{ count($peminjaman) }} transaksi</div>
        </div>

        <div class="report-section">
            <h4>Detail Peminjaman</h4>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjaman as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->user->user_nama }}</td>
                            <td>
                                @foreach ($data->details as $detail)
                                    • {{ $detail->buku->buku_judul }}<br>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($data->peminjaman_tglpinjam)->format('d-m-Y') }}</td>
                            <td>
                                @if ($data->peminjaman_statuskembali == 1)
                                    Selesai
                                @else
                                    Dipinjam
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer-note">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>© {{ date('Y') }} Perpustakaan SMKN6 Malang</p>
        </div>
    </div>

</body>
</html>
