<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\KategoriBuku;
use App\Models\Rak;


class BukuController extends Controller
{
    // Method untuk menampilkan daftar buku
    public function index()
    {
        $bukus = Buku::all(); // Ambil semua data buku
        return view('admin.admin_buku', ['level' => 'admin', 'bukus' => $bukus]); // Kirim data ke view
    }

    // Method untuk menampilkan form tambah buku
    public function create()
{
    $penulis = Penulis::all(); // Ambil data penulis
    $penerbit = Penerbit::all(); // Ambil data penerbit
    $kategori = KategoriBuku::all(); // Ambil data kategori
    $rak = Rak::all(); // Ambil data rak

    return view('admin.create_buku', compact('penulis', 'penerbit', 'kategori', 'rak'));
}


    // Method untuk menyimpan data buku ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_buku' => 'required|string|max:40',
            'penulis_id' => 'required|string|exists:penulis,penulis_id',
            'penerbit_id' => 'required|string|exists:penerbit,penerbit_id',
            'kategori_id' => 'required|string|exists:kategori,kategori_id',
            'rak_id' => 'required|string|exists:rak,rak_id',
            'isbn' => 'required|string|max:16',
            'tahun_terbit' => 'required|integer|digits:4',
        ]);


        $id = mt_rand(1000000000000000, 9999999999999999);

        $data = [
            'buku_id' => $id,
            'buku_judul' => $request->input('judul_buku'),
            'buku_penulis_id' => $request->input('penulis_id'),
            'buku_penerbit_id' => $request->input('penerbit_id'),
            'buku_kategori_id' => $request->input('kategori_id'),
            'buku_rak_id' => $request->input('rak_id'),
            'buku_isbn' => $request->input('isbn'),
            'buku_thnterbit' => $request->input('tahun_terbit'),
        ];

        Buku::create($data);

        return redirect()->route('buku')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Method untuk memperbarui data buku
    public function update(Request $request, $buku_id)
    {
        // Validasi input
        $request->validate([
            'judul_buku' => 'required|string|max:40',
            'penulis_id' => 'required|string|exists:penulis,penulis_id',
            'penerbit_id' => 'required|string|exists:penerbit,penerbit_id',
            'kategori_id' => 'required|string|exists:kategori,kategori_id',
            'rak_id' => 'required|string|exists:rak,rak_id',
            'isbn' => 'required|string|max:16',
            'tahun_terbit' => 'required|integer|digits:4',
        ]);

        $buku = Buku::find($buku_id);
        if (!$buku) {
            return redirect()->route('buku')->withErrors('Buku tidak ditemukan!');
        }

        $data = [
            'buku_judul' => $request->input('judul_buku'),
            'buku_penulis_id' => $request->input('penulis_id'),
            'buku_penerbit_id' => $request->input('penerbit_id'),
            'buku_kategori_id' => $request->input('kategori_id'),
            'buku_rak_id' => $request->input('rak_id'),
            'buku_isbn' => $request->input('isbn'),
            'buku_thnterbit' => $request->input('tahun_terbit'),
        ];

        $buku->update($data);

        return redirect()->route('buku')->with('success', 'Buku berhasil diperbarui!');
    }


    // Method untuk menghapus data buku
    public function delete($buku_id)
    {
        Buku::destroy($buku_id); // Hapus buku berdasarkan ID
        return redirect()->route('buku')->with('deleted', 'Buku berhasil dihapus!');
    }
    public function edit($buku_id)
{
    $buku = Buku::findOrFail($buku_id);
    // Ambil data lain yang diperlukan seperti penulis, penerbit, kategori, dan rak
    $penulis = Penulis::all();
    $penerbit = Penerbit::all();
    $kategori = KategoriBuku::all();
    $rak = Rak::all();

    return view('admin.admin_update_buku', compact('buku', 'penulis', 'penerbit', 'kategori', 'rak'));
}


}
