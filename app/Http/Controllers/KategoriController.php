<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuku;

class KategoriController extends Controller
{
    // Method untuk menyimpan data kategori ke database
    public function create(Request $request)
    {
        // Validasi input form
        $request->validate([
            'kategori_nama' => 'required|string|max:255',
        ]);

        // Buat kategori baru
        KategoriBuku::create([
            'kategori_id' => uniqid(), // Membuat ID unik
            'kategori_nama' => $request->kategori_nama,
        ]);

        // Redirect ke halaman daftar kategori setelah penyimpanan
        return redirect()->route('kategoriBuku')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Method untuk memperbarui data kategori
    public function update(Request $request, $kategori_id)
    {
        // Validasi input form
        $request->validate([
            'kategori_nama' => 'required|string|max:255',
        ]);

        // Cari kategori berdasarkan ID
        $kategori = KategoriBuku::findOrFail($kategori_id);
        $kategori->update([
            'kategori_nama' => $request->kategori_nama,
        ]);

        // Redirect ke halaman daftar kategori setelah pembaruan
        return redirect()->route('kategoriBuku')->with('success', 'Kategori berhasil diperbarui!');
    }

    // Method untuk menghapus data kategori
    public function delete($kategori_id)
    {
        // Hapus kategori berdasarkan ID
        KategoriBuku::destroy($kategori_id);

        // Redirect setelah penghapusan
        return redirect()->route('kategoriBuku')->with('deleted', 'Kategori berhasil dihapus!');
    }

    // Method untuk menampilkan daftar kategori
    public function index()
    {
        $kategoris = KategoriBuku::all();
        return view('kategoriBuku', compact('kategoris'));
    }
}
