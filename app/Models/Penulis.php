<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    use HasFactory;

    protected $table = 'penulis';
    protected $primaryKey = 'penulis_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'penulis_id',
        'penulis_nama_id',
        'penulis_tmptlahir',
        'penulis_tgllahir',
    ];

    public static function readPenulis()
    {
        return self::all();
    }

    public static function readPenulisById($id)
    {
        return self::find($id);
    }
}
