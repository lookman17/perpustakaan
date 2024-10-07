<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /*public function create()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'user_nama' => 'required|string|max:50',
            'user_alamat' => 'required|string|max:50',
            'user_username' => 'required|string|max:50',
            'user_email' => 'required|email|max:50',
            'user_notelp' => 'required|string|max:13',
            'user_password' => 'required|string|min:6',
            'user_level' => 'required|in:admin,anggota',
        ]);

        // Buat user baru
        User::create([
            'user_id' => uniqid(), // Contoh membuat user_id otomatis
            'user_nama' => $request->user_nama,
            'user_alamat' => $request->user_alamat,
            'user_username' => $request->user_username,
            'user_email' => $request->user_email,
            'user_notelp' => $request->user_notelp,
            'user_password' => $request->user_password, // Tanpa hashing
            'user_level' => $request->user_level,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
*/
public function register (Request $request)
{
    $id = mt_rand(1000000000000000, 9999999999999999);

    $data = [
        'user_id' => $id,
        'user_nama' => $request->input('nama'),
        'user_alamat' => $request->input('alamat'),
        'user_username' => $request->input('username'),
        'user_email' => $request->input('email'),
        'user_notelp' => $request->input('notelp'),
        'user_password' => bcrypt($request->input('password'))
    ];

    $user = User::register($data);

    if ($user) {
        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil!');
    } else {
        return back()->withInput();
    }
}
public function login(Request $request)
{
    $credentials = [
        'user_username' => $request->input('user_username'),
        'user_password' => $request->input('user_password')
    ];

    $user = User::where('user_username', $credentials['user_username'])->first();

    if ($user) {
        // Cek apakah password cocok
        if (Hash::check($credentials['user_password'], $user->user_password)) {
            // Cek apakah user memiliki level
            if (is_null($user->user_level) || $user->user_level === '') {
                return back()->withErrors([
                    'message' => 'Akun ini tidak memiliki level. Silakan hubungi admin.',
                ]);
            }

            Auth::login($user);

            // Redirect berdasarkan level user
            if ($user->user_level === 'anggota') {
                return redirect()->route('dashboard'); // Rute untuk dashboard siswa
            } elseif ($user->user_level === 'admin') {
                return redirect()->route('dashboardAdmin'); // Rute untuk dashboard admin
            } else {
                return back()->withErrors([
                    'message' => 'Level pengguna tidak dikenali.',
                ]);
            }
        } else {
            return back()->withErrors([
                'message' => 'Username atau password Anda salah.',
            ]);
        }
    } else {
        return back()->withErrors([
            'message' => 'Username atau password Anda salah.',
        ]);
    }
}
public function logout()
{
    Auth::logout(); // Logout user yang sedang login
    return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
}


}
