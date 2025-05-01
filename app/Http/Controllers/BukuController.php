<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\KategoriBuku;
use App\Models\Rak;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    // Method untuk menampilkan daftar buku
    public function index()
    {
        // Mengambil data buku beserta relasinya dan menerapkan pagination
        $bukus = Buku::with(['penulis', 'penerbit', 'kategori', 'rak']) // Mengambil data dengan relasi
            ->paginate(6); // Menampilkan 10 data per halaman

        return view('admin.admin_buku', [
            'level' => 'admin',
            'bukus' => $bukus
        ]);
    }

    public function siswa()
    {
        $bukus = Buku::with('penulis')->paginate(8);
        return view('public.siswa_buku', compact('bukus'));
    }
    // Method untuk menampilkan form tambah buku
    public function create()
    {
        // Ambil data penulis, penerbit, kategori, dan rak untuk ditampilkan di form
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = KategoriBuku::all();
        $rak = Rak::all();

        return view('admin.create_buku', compact('penulis', 'penerbit', 'kategori', 'rak'));
    }

    // Method untuk menyimpan data buku ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:40',
            'penulis_id' => 'required|string|exists:penulis,penulis_id',
            'penerbit_id' => 'required|string|exists:penerbit,penerbit_id',
            'kategori_id' => 'required|string|exists:kategori,kategori_id',
            'rak_id' => 'required|string|exists:rak,rak_id',
            'isbn' => 'required|string|max:16',
            'tahun_terbit' => 'required|integer|digits:4',
            'buku_stok' => 'required|integer|min:0',
            'buku_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Ambil ID rak yang dipilih
        $rak = Rak::find($request->input('rak_id'));
    
        // Cek apakah stok buku melebihi kapasitas rak
        if ($rak->rak_kapasitas < $request->input('buku_stok')) {
            return redirect()->back()->with('error', 'Stok buku melebihi kapasitas rak!');
        }
    
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
            'buku_stok' => $request->input('buku_stok'),
        ];
    
        if ($request->hasFile('buku_gambar')) {
            $imageName = time() . '.' . $request->buku_gambar->extension();
            $request->buku_gambar->move(public_path('uploads/buku'), $imageName);
            $data['buku_gambar'] = 'uploads/buku/' . $imageName;
        }
    
        // Menambahkan buku baru
        Buku::create($data);
    
        // Mengurangi kapasitas rak sesuai dengan stok buku yang baru
        $rak->rak_kapasitas -= $request->input('buku_stok');
        $rak->save();
    
        return redirect()->route('buku')->with('success', 'Buku berhasil ditambahkan!');
    }
    


    public function update(Request $request, $buku_id)
    {
        $request->validate([
            'judul_buku' => 'required|string|max:40',
            'penulis_id' => 'required|string|exists:penulis,penulis_id',
            'penerbit_id' => 'required|string|exists:penerbit,penerbit_id',
            'kategori_id' => 'required|string|exists:kategori,kategori_id',
            'rak_id' => 'required|string|exists:rak,rak_id',
            'isbn' => 'required|string|max:16',
            'tahun_terbit' => 'required|integer|digits:4',
            'buku_stok' => 'required|integer|min:0',
            'buku_gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Ambil data buku yang lama untuk memeriksa perubahan stok
        $buku = Buku::find($buku_id);
        if (!$buku) {
            return redirect()->route('buku')->with('error', 'Buku tidak ditemukan!');
        }
    
        // Ambil rak yang terkait dengan buku lama dan yang baru
        $rakLama = Rak::find($buku->buku_rak_id);
        $rakBaru = Rak::find($request->input('rak_id'));
    
        // Jika rak berubah, pastikan kapasitas rak baru cukup untuk menampung stok
        if ($rakLama->rak_id !== $rakBaru->rak_id) {
            // Mengurangi kapasitas rak lama
            $rakLama->rak_kapasitas += $buku->buku_stok;
            $rakLama->save();
    
            // Mengecek apakah rak baru memiliki kapasitas yang cukup
            if ($rakBaru->rak_kapasitas < $request->input('buku_stok')) {
                return redirect()->back()->with('error', 'Stok buku melebihi kapasitas rak baru!');
            }
    
            // Mengurangi kapasitas rak baru sesuai dengan stok buku yang akan diperbarui
            $rakBaru->rak_kapasitas -= $request->input('buku_stok');
            $rakBaru->save();
        } else {
            // Jika rak tidak berubah, cukup cek apakah kapasitas rak masih mencukupi
            if ($rakLama->rak_kapasitas < $request->input('buku_stok') - $buku->buku_stok) {
                return redirect()->back()->with('error', 'Stok buku melebihi kapasitas rak!');
            }
    
            // Mengupdate kapasitas rak lama setelah stok buku diperbarui
            $rakLama->rak_kapasitas += ($buku->buku_stok - $request->input('buku_stok'));
            $rakLama->save();
        }
    
        // Update data buku
        $data = [
            'buku_judul' => $request->input('judul_buku'),
            'buku_penulis_id' => $request->input('penulis_id'),
            'buku_penerbit_id' => $request->input('penerbit_id'),
            'buku_kategori_id' => $request->input('kategori_id'),
            'buku_rak_id' => $request->input('rak_id'),
            'buku_isbn' => $request->input('isbn'),
            'buku_thnterbit' => $request->input('tahun_terbit'),
            'buku_stok' => $request->input('buku_stok'),
        ];
    
        // Update gambar buku jika ada
        if ($request->hasFile('buku_gambar')) {
            $imageName = time() . '.' . $request->buku_gambar->extension();
            $request->buku_gambar->move(public_path('uploads/buku'), $imageName);
            $data['buku_gambar'] = 'uploads/buku/' . $imageName;
        }
    
        // Melakukan update data buku
        Buku::where('buku_id', $buku_id)->update($data);
    
        return redirect()->route('buku')->with('success', 'Data buku berhasil diperbarui!');
    }
    

public function delete($buku_id)
{
    // Ambil data buku berdasarkan ID
    $buku = Buku::find($buku_id);

    if (!$buku) {
        return redirect()->route('buku')->with('error', 'Buku tidak ditemukan!');
    }

    $rak = Rak::find($buku->buku_rak_id);

    $rak->rak_kapasitas += $buku->buku_stok;
    $rak->save();

    if ($buku->buku_gambar && file_exists(public_path($buku->buku_gambar))) {
        unlink(public_path($buku->buku_gambar));
    }

    $buku->delete();

    return redirect()->route('buku')->with('success', 'Buku berhasil dihapus!');
}


    public function edit($buku_id)
    {
        $buku = Buku::findOrFail($buku_id);
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = KategoriBuku::all();
        $rak = Rak::all();

        return view('admin.admin_update_buku', compact('buku', 'penulis', 'penerbit', 'kategori', 'rak'));
    }

    public function pinjamMultiple(Request $request)
{
    $bukuIds = $request->input('buku_ids', []);
    
    if (empty($bukuIds)) {
        return redirect()->back()->with('error', 'Tidak ada buku yang dipilih.');
    }
    
    // Mendapatkan tanggal pinjam saat ini
    $tanggalPinjam = Carbon::now();
    // Menambahkan 7 hari untuk tanggal kembali
    $tanggalKembali = $tanggalPinjam->copy()->addDays(7);
    
    // Membuat ID peminjaman unik
    $peminjamanId = Str::random(16);
    
    // Menyimpan data peminjaman dengan status peminjaman_statuskembali = false (belum dikembalikan)
    DB::table('peminjaman')->insert([
        'peminjaman_id' => $peminjamanId,
        'peminjaman_user_id' => Auth::id(),
        'peminjaman_tglpinjam' => $tanggalPinjam,
        'peminjaman_tglkembali' => $tanggalKembali,
        'peminjaman_statuskembali' => false, // Menandakan bahwa buku belum dikembalikan
        'peminjaman_note' => null,
        'peminjaman_denda' => null,
    ]);
    
    // Menyimpan detail peminjaman untuk setiap buku yang dipilih dan mengurangi stok buku
    foreach ($bukuIds as $bukuId) {
        // Mengurangi stok buku yang dipinjam
        $buku = Buku::find($bukuId);
        if ($buku && $buku->buku_stok > 0) {
            $buku->buku_stok -= 1; // Mengurangi stok buku
            $buku->save();
        
            // Menyimpan detail peminjaman
            DB::table('peminjaman_detail')->insert([
                'peminjaman_detail_peminjaman_id' => $peminjamanId,
                'peminjaman_detail_buku_id' => $bukuId,
            ]);

            // Menambah kapasitas rak sesuai dengan rak buku
            $rak = Rak::find($buku->buku_rak_id); // Mengambil rak berdasarkan rak_id buku
            if ($rak) {
                $rak->rak_kapasitas += 1; // Menambah kapasitas rak
                $rak->save();
            }
        } else {
            // Jika stok buku tidak cukup
            return redirect()->route('peminjaman.siswa')->with('error', 'Stok buku tidak mencukupi.');
        }
    }

    return redirect()->route('peminjaman.siswa')->with('success', 'Buku berhasil dipinjam.');
}

}
