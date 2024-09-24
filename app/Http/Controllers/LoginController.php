<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function login ()
{
   return view('login');
}
    public function postLogin (LoginRequest $request)
{
    $validated = $request->validated();

    $username = $validated['username'];
    $password = $validated['password'];

    if ($username && $password) {
        echo "Login berhasil";
    } else {
        return back()->withErrors($validated)->withInput();
    }
}
}
