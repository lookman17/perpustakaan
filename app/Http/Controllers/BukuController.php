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
        // Mengambil data buku beserta relasinya dan menerapkan pagination
        $bukus = Buku::with(['penulis', 'penerbit', 'kategori', 'rak']) // Mengambil data dengan relasi
                     ->paginate(10); // Menampilkan 10 data per halaman

        return view('admin.admin_buku', [
            'level' => 'admin',
            'bukus' => $bukus
        ]);
    }

public function siswa()
    {
        $bukus = Buku::with('penulis')->paginate(9);
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
    // Validasi input
    $request->validate([
        'judul_buku' => 'required|string|max:40',
        'penulis_id' => 'required|string|exists:penulis,penulis_id',
        'penerbit_id' => 'required|string|exists:penerbit,penerbit_id',
        'kategori_id' => 'required|string|exists:kategori,kategori_id',
        'rak_id' => 'required|string|exists:rak,rak_id',
        'isbn' => 'required|string|max:16',
        'tahun_terbit' => 'required|integer|digits:4',
        'buku_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
    ]);

    // Menghasilkan ID secara acak untuk buku
    $id = mt_rand(1000000000000000, 9999999999999999);

    // Mengatur data buku untuk disimpan
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

    // Memastikan buku_gambar ter-upload
    if ($request->hasFile('buku_gambar')) {
        // Simpan gambar ke folder 'uploads/buku'
        $imageName = time() . '.' . $request->buku_gambar->extension();
        $request->buku_gambar->move(public_path('uploads/buku'), $imageName);

        // Masukkan path gambar ke dalam data buku
        $data['buku_gambar'] = 'uploads/buku/' . $imageName;
    }

    // Menyimpan data buku ke database
    Buku::create($data);

    return redirect()->route('buku')->with('success', 'Buku berhasil ditambahkan!');
}
//update
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
            'buku_gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $buku= Buku::find($buku_id);
        if (!$buku) {
            return redirect()->route('buku')->with('error', 'Buku tidak ditemukan!');
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
        if ($request->hasFile('buku_gambar')) {
            // Simpan gambar ke folder 'uploads/buku'
            $imageName = time() . '.' . $request->buku_gambar->extension();
            $request->buku_gambar->move(public_path('uploads/buku'), $imageName);

            // Masukkan path gambar ke dalam data buku
            $data['buku_gambar'] = 'uploads/buku/' . $imageName;
        }

        $buku->update($data);
        return redirect()->route('buku')->with('success', 'Buku berhasil diupdate!');
    }
    //hapus
    public function delete($buku_id)
    {
        Buku::destroy($buku_id);
        return redirect()->route('buku')->with('success', 'Buku berhasil dihapus!');
    }
    // Method untuk menampilkan form edit buku
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
