<?php

namespace App\Helpers;

use Carbon\Carbon;

class DendaHelper
{
    public static function hitungDenda($tgl_pinjam, $tgl_kembali)
    {
        // Batas waktu pengembalian (misalnya 7 hari)
        $batas_kembali = Carbon::parse($tgl_pinjam)->addDays(7);

        // Hitung keterlambatan dalam hari
        $hari_terlambat = $tgl_kembali->diffInDays($batas_kembali);
dd($hari_terlambat); // Cek nilai hari terlambat sebelum menghitung denda


        // Jika tidak ada keterlambatan
        if ($hari_terlambat <= 0) {
            return 0; // Tidak ada denda jika pengembalian tepat waktu atau lebih cepat
        }

        // Denda hari pertama 1000, kemudian 200 per hari setelahnya
        if ($hari_terlambat == 1) {
            $total_denda = 1000; // Denda hari pertama
        } else {
            // Hari pertama 1000, kemudian 200 per hari setelahnya
            $total_denda = 1000 + (($hari_terlambat - 1) * 200); // Denda setelah hari pertama
        }

        return $total_denda;
    }
}


