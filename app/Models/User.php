<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        'user_pict_url', // Tambahkan ini untuk menyimpan URL gambar profil
    ];

    // Metode untuk mengupload profil

public static function upload_profile($id, $data)
{
    $user = self::find($id);

    if ($user) {
        // Hapus gambar lama jika ada (dan bukan default gambar)
        if ($user->user_pict_url && Storage::exists($user->user_pict_url)) {
            Storage::delete($user->user_pict_url);
        }

        // Simpan gambar baru
        if ($data) {
            $fileName = time() . '.' . $data->getClientOriginalExtension();
            $path = $data->storeAs('public/profile_pictures', $fileName);

            // Update database dengan path yang benar
            $user->user_pict_url = str_replace('public/', 'storage/', $path);
            $user->save();

            Log::info("Foto profil berhasil diunggah.", ['user_id' => $user->user_id, 'path' => $user->user_pict_url]);

            return true;
        }
    }

    return false;
}


    // Metode untuk upload profil admin
    public function upload_admin_profile($request, $id)
    {
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');

            // Panggil metode upload_profile
            if (self::upload_profile($id, $file)) {
                return true; // Kembalikan true jika berhasil
            }
        }

        return false; // Kembalikan false jika tidak ada file yang diupload
    }

    protected static function register($data)
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
