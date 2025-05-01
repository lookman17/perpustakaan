<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbit;
use App\Models\KategoriBuku;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;

class PagesController extends Controller
{
    public function dashboard() {
        return view('public.dashboard');
    }
    public function login() {
        return view('login');
    }
    public function register() {
        return view('register');
    }
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
    $jumlahPengguna = User::count();
    $jumlahJudul = Buku::count();
    $jumlahStok = Buku::sum('buku_stok');

    $bukuKategori = DB::table('kategori')
    ->leftJoin('buku', 'kategori.kategori_id', '=', 'buku.buku_kategori_id')
    ->select('kategori.kategori_nama', DB::raw('COUNT(buku.buku_id) as total'))
    ->groupBy('kategori.kategori_nama')
    ->pluck('total', 'kategori.kategori_nama');


    return view('admin.dashboard', compact('jumlahPengguna', 'jumlahJudul', 'jumlahStok', 'bukuKategori'));
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
    $kategoris = KategoriBuku::readKategori();
    return view('admin.kategori_buku', compact('kategoris')); 
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
    $bukus = Buku::all();
    return view('admin.admin_buku', ['level' => 'admin', 'bukus' => $bukus]);
}

public function create_buku()
{
    return view('admin.create_buku');
}

public function update_buku($id)
{
    $buku = Buku::findOrFail($id); // Temukan buku berdasarkan ID
    return view('admin.admin_update_buku', compact('buku'));
}


}


