<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function checker()
    {
        return view('test');
    }

    public function registerPost(RegisterRequest $request)
    {
        $user_id = Str::random(16);
        $user_fullname = $request->first_name . ' ' . $request->last_name;

        $data = [
            'user_id' => $user_id,
            'user_nama' => $user_fullname,
            'user_alamat' => $request->address,
            'user_username' => $request->username,
            'user_email' => $request->email,
            'user_notelp' => $request->phone,
            'password' => bcrypt($request->password),
            'level' => 'anggota',
        ];

        $user = User::register($data);

        if ($user) {
            $credentials = [
                'user_username' => $request->username,
                'password' => $request->password
            ];
            Auth::attempt($credentials);
            return redirect()->route('dashboard');
        }

        return "fail";
    }

    public function loginPost(LoginRequest $request)
    {
        $credentials = [
            'user_username' => $request->username,
            'password' => $request->password
        ];

        // Auth::login tidak bisa (akan melogin user ke user paling terbaru walaupun user ketemu, D:)
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors([
                'message' => 'Username atau password Anda salah.',
            ]);
        }
    }
}
