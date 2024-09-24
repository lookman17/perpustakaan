<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penulis;

class PenulisController extends Controller
{
    // Method untuk menampilkan daftar penulis
    public function index()
    {
        $penuliss = Penulis::all();
        return view('admin.penulis', compact('penuliss')); // Sesuaikan dengan nama view Anda
    }

    // Method untuk menampilkan form tambah penulis
    public function create()
    {
        return view('admin.create_penulis'); // Sesuaikan dengan nama view Anda
    }

    // Method untuk menyimpan data penulis ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'penulis_nama_id' => 'required|string|max:255',
            'penulis_tmptlahir' => 'nullable|string|max:255',
            'penulis_tgllahir' => 'nullable|date',
        ]);

        $id = mt_rand(1000000000000000, 9999999999999999);

        $data = [
            'penulis_id' => $id,
            'penulis_nama_id' => $request->input('penulis_nama_id'),
            'penulis_tmptlahir' => $request->input('penulis_tmptlahir'),
            'penulis_tgllahir' => $request->input('penulis_tgllahir'),
        ];

        Penulis::create($data);

        return redirect()->route('Penulis')->with('success', 'Data penulis berhasil ditambahkan!');
    }

    // Method untuk memperbarui data penulis
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'penulis_nama_id' => 'required|string|max:255',
            'penulis_tmptlahir' => 'nullable|string|max:255',
            'penulis_tgllahir' => 'nullable|date',
        ]);

        $data = $request->only(['penulis_nama_id', 'penulis_tmptlahir', 'penulis_tgllahir']);

        // Update penulis
        Penulis::findOrFail($id)->update($data);

        return redirect()->route('Penulis')->with('success', 'Penulis berhasil diperbarui!');
    }

    // Method untuk menghapus data penulis
    public function delete($id)
    {
        Penulis::destroy($id);
        return redirect()->route('Penulis')->with('deleted', 'Data penulis berhasil dihapus!');
    }
}
