<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function dashboard()
    {
        return view('public.dashboard');
    }
    public function siswa()
    {
        if (auth()->check()) {
            $user_id = auth()->user()->user_id;


            $peminjamans = Peminjaman::with('details.buku')
                ->where('peminjaman_user_id', $user_id)
                ->get();


            if ($peminjamans->isEmpty()) {
                return view('public.siswa_peminjam', ['peminjamans' => $peminjamans]);
            }

            return view('public.siswa_peminjam', compact('peminjamans'));
        } else {
            return redirect('/login');
        }
    }

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
    public function buat()
    {
        $bukus = Buku::all();
        $users = User::all();
        return view('public.create_peminjaman_siswa', compact('bukus', 'users'));
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
    'peminjaman_tglkembali' => $request->tanggal_kembali,
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

        // Atur tanggal kembali ke tanggal saat ini
        $peminjaman->peminjaman_tglkembali = now(); // Atur tanggal kembali ke saat ini
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
public function pinjam($buku_id)
{
    $user = Auth::user();


    $buku = Buku::find($buku_id);

    // Buat peminjaman baru
    $peminjaman = new Peminjaman();
    $peminjaman->peminjaman_user_id = $user->user_id; // ID siswa yang meminjam
    $peminjaman->peminjaman_tglpinjam = now(); // Tanggal pinjam sekarang
    $peminjaman->peminjaman_tglkembali = now();
    $peminjaman->peminjaman_statuskembali = '0';
    $peminjaman->save();

    // Buat detail peminjaman
    $peminjamanDetail = new PeminjamanDetail();
    $peminjamanDetail->peminjaman_detail_peminjaman_id = $peminjaman->peminjaman_id;
    $peminjamanDetail->peminjaman_detail_buku_id = $buku_id;
    $peminjamanDetail->save();

    // Update status buku menjadi Dipinjam

    $buku->save();

    // Redirect ke halaman siswa dengan pesan sukses
    return redirect()->route('peminjaman.siswa')->with('success', 'Buku berhasil dipinjam.');
}

}
