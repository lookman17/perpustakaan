<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';
    public $incrementing = false; // Karena primary key bukan auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string
    public $timestamps = false; // Menonaktifkan timestamps jika tidak digunakan

    protected $fillable = [
        'peminjaman_user_id',
        'peminjaman_tglpinjam',
        'peminjaman_tglkembali',
        'peminjaman_statuskembali',
        'peminjaman_note',
        'peminjaman_denda',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate a unique ID up to 16 characters
            $model->peminjaman_id = strtoupper(substr(bin2hex(random_bytes(8)), 0, 16));
        });
    }



    public function details()
    {
        return $this->hasMany(PeminjamanDetail::class, 'peminjaman_detail_peminjaman_id', 'peminjaman_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'peminjaman_user_id', 'user_id');
    }
}
