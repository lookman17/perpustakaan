<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbit;

class PenerbitController extends Controller
{
    // Method untuk menyimpan data penerbit ke database
    public function create (Request $request)
    {
        $id = mt_rand(1000000000000000, 9999999999999999);

        $data = [
            'penerbit_id' => $id,
            'penerbit_nama' => $request->input('nama'),
            'penerbit_alamat' => $request->input('alamat'),
            'penerbit_notelp' => $request->input('notelp'),
            'penerbit_email' => $request->input('email'),
        ];

        Penerbit::createPenerbit($data);

        return redirect()->route('Penerbit')->with('success', 'Data penerbit berhasil ditambahkan!');
    }

    // Method untuk memperbarui data penerbit
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'penerbit_nama' => 'required|string|max:255',
            'penerbit_alamat' => 'required|string|max:255',
            'penerbit_notelp' => 'required|string|max:15',
            'penerbit_email' => 'required|email|max:255',
        ]);

        // Ambil data dari request
        $data = $request->only(['penerbit_nama', 'penerbit_alamat', 'penerbit_notelp', 'penerbit_email']);

        // Update penerbit
        $result = Penerbit::updatePenerbit($id, $data);

        if (!$result) {
            return redirect()->route('Penerbit')->withErrors('Penerbit tidak ditemukan!');
        }

        // Redirect ke halaman daftar penerbit
        return redirect()->route('Penerbit')->with('success', 'Penerbit berhasil diperbarui!');
    }


    // Method untuk menghapus data penerbit
    public function delete ($id)
{
    Penerbit::deletePenerbit($id);

    return redirect()->route('Penerbit')->with('deleted', 'Data penerbit berhasil dihapus!');
}

    // Method untuk menampilkan daftar penerbit
    public function index()
    {
        $penerbits = Penerbit::all();
        return view('Penerbit', compact('penerbits'));
    }
}
