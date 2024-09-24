<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function data ()
     {
       return view('buku');
     }

public function postdata (BukuRequest $request)
    {
        $validated = $request->validated();

        $databuku = [
            'kode_buku' => $validated['kode_buku'],
            'nama_buku' => $validated['nama_buku'],
            'penerbit_buku' => $validated['penerbit_buku'],
            'penulis_buku' => $validated['penulis_buku'],
            'tahun_terbit' => $validated['tahun_terbit'],
        ];

        if ($databuku) {
            dd($databuku);
        } else {
            return back()->withErrors($validated)->withInput();
        }
    }

}