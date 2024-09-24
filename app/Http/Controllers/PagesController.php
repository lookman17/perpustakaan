<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbit;
use App\Models\KategoriBuku;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Peminjam;

class PagesController extends Controller
{
    public function loginPage () {
        return view('public.login');
  }
  public function adminBuku() {
    return view('admin.admin_buku');
  }
  public function adminPeminjam() {
    return view('admin.admin_peminjam');
  }

  public function dashboardAdmin () {
    return view('admin.dashboard', ['level' => 'admin']);
}
public function bukuSiswa(){
    return view('public.siswa_buku');
  }
  public function Pengaturan(){
    return view('public.pengaturan',);
  }
  public function siswaPeminjam(){
    return view('public.siswa_peminjam');
  }
  public function adminPengaturan(){
    return view('admin.pengaturan_admin',);
}
public function create_penerbit(){
    return view('admin.create_penerbit');
}
public function penerbit() {
    $data = Penerbit::readPenerbit();

    return view('admin.penerbit', ['level' => 'admin'])->with('penerbit', $data);
}
public function update_penerbit ($id) {
    $penerbit = Penerbit::readPenerbitById($id);

    return view('admin.update_penerbit', ['level' => 'admin'])->with('penerbit', $penerbit);
}
//kategoribuku
public function kategoriBuku()
{
    $kategoris = KategoriBuku::readKategori(); // Mengambil semua kategori
    return view('admin.kategori_buku', compact('kategoris')); // Mengirim data kategori ke view
}

// Menampilkan form create kategori
public function create()
{
    return view('admin.create_kategori_buku');
}

// Menampilkan form update kategori
public function update_kategori($kategori_id)
{
    $kategori = KategoriBuku::findOrFail($kategori_id);
    return view('admin.update_kategori_buku', compact('kategori'));
}
// Menampilkan daftar buku
public function buku()
{
    $bukus = Buku::all(); // Ambil semua data buku
    return view('admin.admin_buku', ['level' => 'admin', 'bukus' => $bukus]); // Kirim data ke view
}

public function create_buku()
{
    return view('admin.create_buku'); // Menampilkan formulir untuk menambahkan buku
}

public function update_buku($id)
{
    $buku = Buku::findOrFail($id); // Temukan buku berdasarkan ID
    return view('admin.admin_update_buku', compact('buku')); // Tampilkan form untuk mengubah buku
}


}


