<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    use HasFactory;

    protected $table = 'rak';
    protected $primaryKey = 'rak_id';
    public $incrementing = false; // Menyatakan bahwa primary key bukan auto-increment
    protected $keyType = 'string'; // Menyatakan bahwa primary key adalah string
    public $timestamps = false; // Tidak menggunakan timestamps

    protected $fillable = [
        'rak_id',
        'rak_nama',
        'rak_lokasi',
        'rak_kapasitas',
    ];
}
