<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'penerbit_nama',
        'penerbit_alamat',
        'penerbit_notelp',
        'penerbit_email',
    ];
    protected static function createPenerbit ($data)
    {
        return DB::table('penerbit')->insert($data);
    }

    // Metode untuk membaca semua penerbit
    protected static function readPenerbit ()
    {
        $data = DB::table('penerbit')->paginate(4);

        return $data;
    }
public function penerbit() {
    $data = Penerbit::readPenerbit();

    return view('Penerbit', ['level' => 'admin'])->with('penerbit', $data);
}
protected static function updatePenerbit ($id, $data)
{
    $penerbit = DB::table('penerbit')->where('penerbit_id', $id)->first();

    if ($penerbit) {
        DB::table('penerbit')->where('penerbit_id', $id)->update($data);
        return $data;
    }

    return null;
}


    // Metode untuk membaca penerbit berdasarkan ID
    protected static function readPenerbitById ($id)
    {
        $penerbit = DB::table('penerbit')->where('penerbit_id', $id)->first();

        return $penerbit;
    }
    protected static function deletePenerbit ($id)
    {
        return DB::table('penerbit')->where('penerbit_id', $id)->delete();
    }
}
