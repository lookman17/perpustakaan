<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;

    protected $table = 'kategori'; // Nama tabel di database
    protected $primaryKey = 'kategori_id'; // Nama kolom primary key di tabel
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kategori_id',
        'kategori_nama', // Kolom yang ingin diisi secara massal
    ];

    // Metode untuk membaca semua kategori
    public static function readKategori()
    {
        return self::all();
    }

    // Metode untuk membaca kategori berdasarkan ID
    public static function readKategoriById($id)
    {
        return self::find($id);
    }
}
