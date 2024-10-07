<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements AuthenticatableContract
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false; // Jika ID adalah string
    public $timestamps = false; // Menonaktifkan timestamps

    protected $fillable = [
        'user_id',
        'user_nama',
        'user_alamat',
        'user_username',
        'user_email',
        'user_notelp',
        'user_password',
        'user_level',
    ];

    protected static function register ($data)
    {
        return self::create($data);
    }
    // Menambahkan metode untuk mengembalikan password yang di-hash
    public function getAuthPassword()
    {
        return $this->user_password; // Mengembalikan password yang di-hash
    }
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'peminjaman_user_id', 'user_id');
    }

}
