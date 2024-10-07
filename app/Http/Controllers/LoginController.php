<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    // Proses login
    public function loginPost(Request $request)
    {

        $request->validate([
            'user_username' => 'required|min:3',
            'user_password' => 'required|min:6',
        ]);

        // Cek apakah user dengan username yang dimasukkan ada
        $user = User::where('user_username', $request->user_username)->first();

        // Cek jika user ditemukan dan password cocok
        if ($user && $user->user_password === $request->user_password) {
            Auth::login($user);
            return redirect()->route('dashboardAdmin');
        }


        return redirect()->back()->withErrors([
            'login_error' => 'Username atau password salah.',
        ]);
    }


    public function logout()
    {
        Auth::logout(); // Logout user
        return redirect()->route('login');
    }
}
