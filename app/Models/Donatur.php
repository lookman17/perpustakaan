<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    use HasFactory;

    protected $table = 'donatur';
    protected $primaryKey = 'donatur_id'; 
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';

    protected $fillable = [
        'donatur_id',
        'donatur_nama',
    ];

    public static function readDonatur()
    {
        return self::all();
    }

    public static function readDonaturById($id)
    {
        return self::find($id);
    }
}
