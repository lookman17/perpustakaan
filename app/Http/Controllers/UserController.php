<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Method untuk menampilkan daftar pengguna
    public function index()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    // Method untuk menampilkan form tambah pengguna
    public function create()
    {
        return view('admin.create_user'); // Pastikan mengarah ke view yang benar
    }

    // Method untuk menyimpan pengguna baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_email' => 'required|email',
            'user_username' => 'required|string|max:50',
            'user_level' => 'required|in:admin,anggota',
        ]);

        // Generate user_id dengan panjang maksimum 16 karakter
        $user_id = substr(bin2hex(random_bytes(8)), 0, 16); // 16 karakter

        // Simpan data
        User::create(array_merge($request->all(), ['user_id' => $user_id]));

        // Redirect ke halaman user
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }




    // Method untuk menampilkan form edit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.update_user', compact('user'));
    }

    // Method untuk memperbarui pengguna
    public function update(Request $request, $user_id)
    {
        // Validasi input
        $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_email' => 'required|email',
            'user_username' => 'required|string|max:50',
            'user_level' => 'required|in:admin,anggota',
            'user_password' => 'nullable|string|min:6', // Biarkan password nullable
        ]);

        $user = User::findOrFail($user_id);

        // Ambil data dari request
        $data = $request->all();

        // Cek jika password diinput
        if (!empty($data['user_password'])) {
            $data['user_password'] = bcrypt($data['user_password']); // Hash password
        } else {
            unset($data['user_password']); // Hapus password jika tidak ada input
        }

        $user->update($data);

        // Redirect ke halaman daftar user
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }



    // Method untuk menghapus pengguna
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('user.index')->with('deleted', 'Pengguna berhasil dihapus!');
    }
}
