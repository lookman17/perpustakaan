<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['details', 'user'])->get();
        return view('admin.admin_peminjam', compact('peminjamans'));
    }

    public function create()
    {
        $bukus = Buku::all();
        $users = User::all();
        return view('admin.create_peminjaman', compact('bukus', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|string|max:16',
            'tanggal_peminjaman' => 'required|date',
            'buku_ids' => 'required|array',
        ]);

        // Generate peminjaman_id
        $peminjaman_id = $this->generatePeminjamanId();

        // Simpan data peminjaman tanpa tanggal kembali
       // Simpan data peminjaman
$peminjaman = Peminjaman::create([
    'peminjaman_id' => $peminjaman_id,
    'peminjaman_user_id' => $request->user_id,
    'peminjaman_tglpinjam' => $request->tanggal_peminjaman,
    'peminjaman_tglkembali' => $request->tanggal_kembali, // Simpan tanggal kembali
    'peminjaman_statuskembali' => false,
    'peminjaman_note' => null,
    'peminjaman_denda' => null,
]);


        // Simpan detail peminjaman
        foreach ($request->buku_ids as $buku_id) {
            $peminjaman->details()->create([
                'peminjaman_detail_buku_id' => $buku_id,
                'peminjaman_detail_peminjaman_id' => $peminjaman_id,
            ]);
        }

        return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil ditambahkan!');
    }








    private function generatePeminjamanId()
    {
        return strtoupper(substr(bin2hex(random_bytes(8)), 0, 16)); // Menghasilkan ID 16 karakter
    }



    public function status($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);
        return view('admin.status_peminjaman', compact('peminjaman'));
    }


    public function update(Request $request, $id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $peminjaman->peminjaman_statuskembali = 1; // Status sudah kembali

    // Atur tanggal kembali dan denda
    $peminjaman->peminjaman_tglkembali = now(); // Atur tanggal kembali
    $peminjaman->peminjaman_denda = 0; // Atur denda jika perlu

    // Simpan perubahan
    $peminjaman->save();

    return redirect()->route('peminjaman')->with('success', 'Status peminjaman diperbarui menjadi selesai!');
}



    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->details()->delete();
        $peminjaman->delete();

        return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil dihapus!');
    }
    public function updateStatus(Request $request, $id)
{
    // Validasi input jika diperlukan
    $request->validate([
        'peminjaman_tglkembali' => 'required|date',
        'peminjaman_denda' => 'nullable|numeric',
        'peminjaman_note' => 'nullable|string',
    ]);

    // Ambil peminjaman berdasarkan ID
    $peminjaman = Peminjaman::findOrFail($id);

    // Update status peminjaman, tanggal kembali, denda, dan catatan
    $peminjaman->peminjaman_statuskembali = true; // Tandai sebagai selesai
    $peminjaman->peminjaman_tglkembali = $request->peminjaman_tglkembali;
    $peminjaman->peminjaman_denda = $request->peminjaman_denda;
    $peminjaman->peminjaman_note = $request->peminjaman_note;

    // Simpan perubahan
    $peminjaman->save();

    return redirect()->route('peminjaman')->with('success', 'Status peminjaman diperbarui!');
}





}
