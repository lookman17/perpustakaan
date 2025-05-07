<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\KategoriBuku;
use App\Models\Rak;
use App\Models\Donatur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    // Method untuk menampilkan daftar buku
    public function index(Request $request)
{
    $kategoriFilter = $request->input('kategori');

    $query = Buku::with(['penulis', 'penerbit', 'kategori', 'rak','donatur']);

    if ($kategoriFilter) {
        $query->whereHas('kategori', function ($q) use ($kategoriFilter) {
            $q->where('kategori_id', $kategoriFilter);
        });
    }

    $bukus = $query->paginate(5)->appends(['kategori' => $kategoriFilter]);

    $kategoris = KategoriBuku::all(); // untuk dropdown

    return view('admin.admin_buku', [
        'level' => 'admin',
        'bukus' => $bukus,
        'kategoris' => $kategoris,
        'selectedKategori' => $kategoriFilter
    ]);
}



    public function siswa()
    {
        $bukus = Buku::with('penulis')->paginate(8);
        return view('public.siswa_buku', compact('bukus'));
    }
    public function create()
    {
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $kategori = KategoriBuku::all();
        $rak = Rak::all();
        $donatur = Donatur::all();

        return view('admin.create_buku', compact('penulis', 'penerbit', 'kategori', 'rak','donatur'));
    }

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
            'donatur_id' => 'required|string|exists:donatur,donatur_id',
            'buku_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        
        ]);
    
        $rak = Rak::find($request->input('rak_id'));
    
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
            'buku_donatur_id' => $request->input('donatur_id'),

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
    
        if ($request->hasFile('buku_gambar')) {
            // Hapus gambar lama jika ada
            if ($buku->buku_gambar && file_exists(public_path($buku->buku_gambar))) {
                unlink(public_path($buku->buku_gambar));
            }
        
            // Simpan gambar baru
            $imageName = time() . '.' . $request->buku_gambar->extension();
            $request->buku_gambar->move(public_path('uploads/buku'), $imageName);
            $data['buku_gambar'] = 'uploads/buku/' . $imageName;
        }
        
    
        Buku::where('buku_id', $buku_id)->update($data);
    
        return redirect()->route('buku')->with('success', 'Data buku berhasil diperbarui!');
    }
    

public function delete($buku_id)
{
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
    $bukuData = $request->input('buku_ids', []);

    // Filter hanya buku yang jumlah pinjamnya > 0
    $bukuData = array_filter($bukuData, function ($jumlah) {
        return $jumlah > 0;
    });

    if (empty($bukuData)) {
        return redirect()->back()->with('error', 'Tidak ada buku yang dipilih.');
    }

    // Cek stok cukup untuk semua buku
    foreach ($bukuData as $bukuId => $jumlah) {
        $buku = Buku::find($bukuId);
        if (!$buku || $buku->buku_stok < $jumlah) {
            return redirect()->route('peminjaman.siswa')->with('error', 'Stok buku "' . ($buku->buku_judul ?? 'tidak ditemukan') . '" tidak mencukupi.');
        }
    }

    // Buat peminjaman
    $tanggalPinjam = Carbon::now();
    $tanggalKembali = $tanggalPinjam->copy()->addDays(7);
    $peminjamanId = Str::random(16);

    DB::table('peminjaman')->insert([
        'peminjaman_id' => $peminjamanId,
        'peminjaman_user_id' => Auth::id(),
        'peminjaman_tglpinjam' => $tanggalPinjam,
        'peminjaman_tglkembali' => $tanggalKembali,
        'peminjaman_statuskembali' => false,
        'peminjaman_note' => null,
        'peminjaman_denda' => null,
    ]);

    // Simpan detail dan update stok
    foreach ($bukuData as $bukuId => $jumlah) {
        $buku = Buku::find($bukuId);
        $buku->buku_stok -= $jumlah;
        $buku->save();

        for ($i = 0; $i < $jumlah; $i++) {
            DB::table('peminjaman_detail')->insert([
                'peminjaman_detail_peminjaman_id' => $peminjamanId,
                'peminjaman_detail_buku_id' => $bukuId,
            ]);
        }

        $rak = Rak::find($buku->buku_rak_id);
        if ($rak) {
            $rak->rak_kapasitas += $jumlah;
            $rak->save();
        }
    }

    return redirect()->route('peminjaman.siswa')->with('success', 'Buku berhasil dipinjam.');
}


}
