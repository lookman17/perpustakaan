<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_detail';
    protected $primaryKey = 'peminjaman_detail_id';
    public $timestamps = false; // Jika tabel tidak memiliki kolom created_at dan updated_at

    protected $fillable = [
        'peminjaman_detail_id',
        'peminjaman_detail_peminjaman_id',
        'peminjaman_detail_buku_id',
    ];

    // Relasi many-to-one dengan Peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_detail_peminjaman_id', 'peminjaman_id');
    }
public function buku()
{
    return $this->belongsTo(Buku::class, 'peminjaman_detail_buku_id', 'buku_id');
}

}
