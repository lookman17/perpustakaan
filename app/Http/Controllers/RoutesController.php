<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoutesController extends Controller
{
    public function Dashboard() {
        return 'Hallo, ini halaman dashboard yang dibuat dengan controller Laravel';
        
    }
    public function perpustakaan ($buku)
    {
        if ($buku === 'malam') {
            return abort(403, 'Kamu tidak memiliki hak akses ke buku ' . $buku);
        } else if ($buku === 'siang') {
            return 'Kamu mengakses buku ' . $buku;
        } else {
            return abort(404);
        }
    }
}

