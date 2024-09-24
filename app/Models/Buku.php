<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'buku_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'buku_id',
        'buku_judul',
        'buku_penulis_id',
        'buku_penerbit_id',
        'buku_kategori_id',
        'buku_rak_id',
        'buku_isbn',
        'buku_thnterbit',
    ];
    // ...

    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'buku_penulis_id');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'buku_penerbit_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'buku_kategori_id');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'buku_rak_id');
    }
}


