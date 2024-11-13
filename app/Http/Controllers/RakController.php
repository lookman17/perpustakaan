<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    // Show all Rak records
    public function index()
    {
        $raks = Rak::Paginate(4);
        return view('admin.rak', compact('raks'));
    }

    // Show form for creating a new Rak
    public function create()
    {
        $raks = Rak::all();
        return view('admin.create_rak');
    }

    // Store a new Rak in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rak_nama' => 'required|string|max:20',
            'rak_lokasi' => 'required|string|max:50',
            'rak_kapasitas' => 'required|integer',
        ]);

        // Generate a random ID for rak_id
        $rak_id = strtoupper(bin2hex(random_bytes(8))); // Generates a random 16-character string

        // Create the Rak instance with the random ID
        Rak::create(array_merge($validated, ['rak_id' => $rak_id]));

        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan');
    }

    // Show form for editing a specific Rak
    public function edit($rak_id)
    {
        $rak = Rak::findOrFail($rak_id);
        $raks = Rak::all(); // Ambil semua rak untuk dropdown
        return view('admin.update_rak', compact('rak', 'raks'));
    }

    // Update an existing Rak in the database
    public function update(Request $request, $rak_id)
    {
        $validated = $request->validate([
            'rak_nama' => 'required|string|max:20',
            'rak_lokasi' => 'required|string|max:50',
            'rak_kapasitas' => 'required|integer',
        ]);

        $rak = Rak::findOrFail($rak_id);
        $rak->update($validated);
        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui');
    }

    // Delete a Rak from the database
    public function destroy($rak_id)
    {
        $rak = Rak::findOrFail($rak_id);
        $rak->delete();
        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus');
    }
}
