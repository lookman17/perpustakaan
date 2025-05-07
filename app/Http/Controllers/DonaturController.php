<?php

namespace App\Http\Controllers;

use App\Models\Donatur;
use Illuminate\Http\Request;

class DonaturController extends Controller
{
    public function create(Request $request)
    {$request->validate([
        'donatur_nama' => 'required|string|max:255',
    ]);

    $id = mt_rand(1000000000000000, 9999999999999999);

    $data = [ 
        'donatur_id' => $id,
        'donatur_nama' => $request->input('donatur_nama'),
    ];

    Donatur::create($data);

    return redirect()->route('donatur')->with('success', 'Data penulis berhasil ditambahkan!');
}

    public function update(Request $request, $donatur_id)
    {
        // Validasi input form
        $request->validate([
            'donatur_nama' => 'required|string|max:255',
        ]);

        // Cari kategori berdasarkan ID
        $donatur = Donatur::findOrFail($donatur_id);
        $donatur->update([
            'donatur_nama' => $request->donatur_nama,
        ]);

        // Redirect ke halaman daftar kategori setelah pembaruan
        return redirect()->route('donatur')->with('success', 'Kategori berhasil diperbarui!');
    }
    public function delete($donatur_id)
    {
        Donatur::destroy($donatur_id);

        return redirect()->route('donatur')->with('deleted', 'Kategori berhasil dihapus!');
    }
    public function index(Request $request)
{
    $search = $request->input('search');

    $donaturs = Donatur::when($search, function ($query, $search) {
        return $query->where('donatur_nama', 'like', '%' . $search . '%');
    })
    ->paginate(10);

    return view('admin.donatur', compact('donaturs'));
}

public function tambah()
{
    return view('admin.create_donatur');
}
public function updatedonatur($id)
{
    $donatur = Donatur::findOrFail($id);

    return view('admin.donatur_update', compact('donatur'));

}
}
