<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanDetail;
use App\Models\Buku;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function cetakStruk($id)
    {
        $peminjaman = Peminjaman::with(['user', 'details.buku'])->findOrFail($id);
        $pdf = PDF::loadView('admin.peminjaman-laporan-id', compact('peminjaman'))
;
        return $pdf->download('struk-peminjaman.pdf');
    }


    public function cetakLaporan(Request $request)
    {
        $periode = $request->periode;

        // Cek jika memilih semua periode (history peminjaman)
        if ($periode == 'semua') {
            $peminjaman = Peminjaman::with(['user', 'details.buku'])->get();
            $periode = 'Semua History Peminjaman';
        } else {
            // Jika memilih rentang tanggal
            $start = $request->start_date;
            $end = $request->end_date;

            $peminjaman = Peminjaman::with(['user', 'details.buku'])
                ->whereBetween('peminjaman_tglpinjam', [$start, $end])
                ->get();

            $periode = Carbon::parse($start)->translatedFormat('d F Y') . ' sampai ' . Carbon::parse($end)->translatedFormat('d F Y');
        }

        // Menghasilkan PDF
        $pdf = Pdf::loadView('admin.Laporan-peminjaman', compact('peminjaman', 'periode'))
        ->setPaper('A4', 'portrait');

        return $pdf->download('laporan_peminjaman.pdf'); // Untuk langsung mendownload
    }

    public function siswa()
    {
        if (Auth::check()) {
            $user_id = Auth::user()->user_id;

            $peminjamans = Peminjaman::with('details.buku')
                ->where('peminjaman_user_id', $user_id)
                ->get();

            foreach ($peminjamans as $peminjaman) {
                if (!$peminjaman->peminjaman_statuskembali) {
                    $tgl_pinjam = $peminjaman->peminjaman_tglpinjam;
                    $tgl_sekarang = date('Y-m-d');

                    $total_denda = $this->hitungDenda($tgl_pinjam, $tgl_sekarang);

                    $peminjaman->peminjaman_denda = $total_denda;
                    $peminjaman->save();
                }
            }

            $peminjamans = Peminjaman::with('details.buku')
                ->where('peminjaman_user_id', $user_id)
                ->paginate(10);

            return view('public.siswa_peminjam', ['peminjamans' => $peminjamans]);
        }

        return redirect('/login');
    }

    public function hitungDenda($tgl_pinjam, $tgl_kembali)
    {
        $tgl_pinjam_obj = date_create($tgl_pinjam);
        $batas_kembali_obj = date_create(date('Y-m-d', strtotime($tgl_pinjam . ' +7 days')));
        $tgl_kembali_obj = date_create($tgl_kembali);

        if ($tgl_kembali_obj > $batas_kembali_obj) {
            $selisih = date_diff($batas_kembali_obj, $tgl_kembali_obj)->days;

            if ($selisih == 1) {
                return 1000;
            } else {
                return 1000 + (($selisih - 1) * 200);
            }
        }

        return 0;
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $tgl_pinjam = $peminjaman->peminjaman_tglpinjam;
        $tgl_kembali = date('Y-m-d');

        $total_denda = $this->hitungDenda($tgl_pinjam, $tgl_kembali);

        $peminjaman->peminjaman_statuskembali = 1;
        $peminjaman->peminjaman_tglkembali = $tgl_kembali;
        $peminjaman->peminjaman_denda = $total_denda;
        $peminjaman->save();

        return redirect()->route('peminjaman')->with('success', 'Status peminjaman diperbarui! Denda: Rp ' . number_format($total_denda));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $peminjamans = Peminjaman::with(['details.buku', 'user'])
            ->whereHas('user', function ($query) use ($search) {
                $query->where('user_nama', 'like', "%$search%");
            })
            ->orWhereHas('details.buku', function ($query) use ($search) {
                $query->where('buku_judul', 'like', "%$search%");
            })
            ->paginate(10);

        return view('admin.admin_peminjam', compact('peminjamans'));
    }

    public function index()
    {
        $peminjamans = Peminjaman::with(['details', 'user'])
            ->orderBy('peminjaman_tglpinjam', 'desc')
            ->paginate(5);

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

        $peminjaman_id = $this->generatePeminjamanId();

        $peminjaman = Peminjaman::create([
            'peminjaman_id' => $peminjaman_id,
            'peminjaman_user_id' => $request->user_id,
            'peminjaman_tglpinjam' => $request->tanggal_peminjaman,
            'peminjaman_tglkembali' => date('Y-m-d', strtotime($request->tanggal_peminjaman . ' +7 days')),
            'peminjaman_statuskembali' => false,
            'peminjaman_note' => null,
            'peminjaman_denda' => null,
        ]);

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
        return strtoupper(substr(bin2hex(random_bytes(8)), 0, 16));
    }

    public function status($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);
        return view('admin.status_peminjaman', compact('peminjaman'));
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
        $request->validate([
            'peminjaman_tglkembali' => 'required|date',
            'peminjaman_denda' => 'nullable|numeric',
            'peminjaman_note' => 'nullable|string',
        ]);

        // Mendapatkan peminjaman dan detail peminjaman
        $peminjaman = Peminjaman::with('details.buku')->findOrFail($id);

        // Mengupdate status peminjaman
        $peminjaman->peminjaman_statuskembali = true;
        $peminjaman->peminjaman_tglkembali = $request->peminjaman_tglkembali;
        $peminjaman->peminjaman_denda = $request->peminjaman_denda;
        $peminjaman->peminjaman_note = $request->peminjaman_note;
        $peminjaman->save();

        // Loop melalui detail peminjaman untuk setiap buku yang dipinjam
        foreach ($peminjaman->details as $detail) {
            $buku = $detail->buku;

            // Mengembalikan stok buku
            $buku->buku_stok += 1;
            $buku->save();

            // Menambah kapasitas rak saat buku dikembalikan
            $rak = $buku->rak;
            if ($rak) {
                $rak->rak_kapasitas -= 1;
                $rak->save();
            }
        }

        return redirect()->route('peminjaman')->with('success', 'Status peminjaman diperbarui! Buku berhasil dikembalikan.');
    }



    public function pinjam($buku_id)
    {
        $user = Auth::user();
        $buku = Buku::find($buku_id);

        // Pastikan stok buku lebih dari 0
        if ($buku->buku_stok > 0) {
            // Kurangi stok buku yang dipinjam
            $buku->buku_stok -= 1;
            $buku->save();

            // Mengurangi kapasitas rak saat buku dipinjam
            $rak = $buku->rak; // Pastikan buku memiliki relasi ke rak
            if ($rak) {
                $rak->rak_kapasitas -= 1; // Kurangi kapasitas rak karena buku dipinjam
                $rak->save();
            }

            // Tanggal peminjaman
            $tgl_pinjam = date('Y-m-d', strtotime('+1 day'));
            $tgl_kembali = date('Y-m-d', strtotime('+7 days'));

            // Simpan data peminjaman
            $peminjaman = new Peminjaman();
            $peminjaman->peminjaman_id = $this->generatePeminjamanId();
            $peminjaman->peminjaman_user_id = $user->user_id;
            $peminjaman->peminjaman_tglpinjam = $tgl_pinjam;
            $peminjaman->peminjaman_tglkembali = $tgl_kembali;
            $peminjaman->peminjaman_statuskembali = false;
            $peminjaman->save();

            // Simpan detail peminjaman
            $peminjamanDetail = new PeminjamanDetail();
            $peminjamanDetail->peminjaman_detail_peminjaman_id = $peminjaman->peminjaman_id;
            $peminjamanDetail->peminjaman_detail_buku_id = $buku_id;
            $peminjamanDetail->save();

            return redirect()->route('peminjaman.siswa')->with('success', 'Buku berhasil dipinjam.');
        } else {
            // Jika stok buku tidak tersedia
            return redirect()->route('peminjaman.siswa')->with('error', 'Stok buku tidak tersedia.');
        }
    }
}
