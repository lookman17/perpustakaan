<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    use HasFactory;

    protected $table = 'penerbit'; // Nama tabel di database
    protected $primaryKey = 'penerbit_id'; // Nama kolom primary key di tabel
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penerbit_id',
        'penerbit_nama', // Kolom yang ingin diisi secara massal
        'penerbit_alamat',
        'penerbit_notelp',
        'penerbit_email',
    ];
    protected static function createPenerbit ($data)
{
    return self::create($data);
}

    // Metode untuk membaca semua penerbit
    protected static function readPenerbit ()
{
    $data = self::all();

    return $data;
}
public function penerbit() {
    $data = Penerbit::readPenerbit();

    return view('Penerbit', ['level' => 'admin'])->with('penerbit', $data);
}
protected static function updatePenerbit($id, $data)
{
    $penerbit = self::find($id);

    if ($penerbit) {
        $penerbit->update($data);
        return $penerbit;
    }

    return null; // atau throw exception jika perlu
}


    // Metode untuk membaca penerbit berdasarkan ID
    protected static function readPenerbitById ($id)
    {
        $penerbit = self::find($id);

        return $penerbit;
    }
    protected static function deletePenerbit ($id)
{
    return self::destroy($id);
}
}
