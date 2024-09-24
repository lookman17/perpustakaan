<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RakController;




Route::get('/Request', [RequestController::class, 'store']);

Route::get('/nama', function() {
    $nama = session('nama');
    return 'Halaman nama dengan nama ' . $nama;
});

Route::get('/hello', function () {
    return response($content = 'Hallo Laravel')
        ->withHeaders([
            'Content-Type' => 'text/html',
            'X-Header-One' => 'Header Value 1',
            'X-Header-Two' => 'Header Value 2',
        ]);
});

Route::get('/perpustakaan/{buku}', [RoutesController::class, 'perpustakaan']);




//Bootstrap

Route::get('/bootstrap', function () {
    return view('bootstrap');
});

//modul 5
Route::get('/login', [PagesController::class, 'loginPage'])->name('login');
Route::get('/dashboard', [PagesController::class, 'dashboardAdmin'])->name('dashboardAdmin');


Route::get('/siswa_buku', [PagesController::class, 'bukuSiswa'])->name('bukuSiswa');
Route::get('/admin_buku', [PagesController::class, 'adminBuku'])->name('adminBuku');
Route::get('/admin_peminjam', [PagesController::class, 'adminPeminjam'])->name('adminPeminjam');
Route::get('/pengaturan', [PagesController::class, 'Pengaturan'])->name('Pengaturan');
Route::get('/siswaPeminjam', [PagesController::class, 'siswaPeminjam'])->name('siswaPeminjam');
Route::get('/pengaturan_admin', [PagesController::class, 'adminPengaturan'])->name('adminPengaturan');

//modul 6
//penerbit
Route::get('/Penerbit', [PagesController::class, 'penerbit'])->name('Penerbit');
Route::post('/createpenerbit', [PenerbitController::class, 'create'])->name('action.createpenerbit');
Route::get('/createpenerbit', [PagesController:: class, 'create_penerbit'])->name('create_penerbit');
Route::get('/update_penerbit/{penerbit_id}', [PagesController::class, 'update_penerbit'])->name('update_penerbit');
Route::patch('/penerbit/{penerbit_id}', [PenerbitController::class, 'update'])->name('penerbit.update');
Route::delete('/penerbit/{penerbit_id}', [PenerbitController::class, 'delete'])->name('penerbit.delete');
//
//kategori
Route::get('/kategoriBuku', [PagesController::class, 'kategoriBuku'])->name('kategoriBuku');
Route::post('/createkategori', [KategoriController::class, 'create'])->name('action.createkategoribuku');
Route::get('/createkategori', [PagesController::class, 'create'])->name('create_kategori_buku');
Route::get('/update_kategori/{kategori_id}', [PagesController::class, 'update_kategori'])->name('update_kategori');
Route::patch('/kategori/{kategori_id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{kategori_id}', [KategoriController::class, 'delete'])->name('kategori.delete');

//buku

Route::get('/buku', [BukuController::class, 'index'])->name('buku');
Route::get('/create_buku', [BukuController::class, 'create'])->name('create_buku');
Route::post('/create_buku', [BukuController::class, 'store'])->name('action.create_buku');
Route::get('/update_buku/{buku_id}', [BukuController::class, 'edit'])->name('update_buku');
Route::patch('/buku/{buku_id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{buku_id}', [BukuController::class, 'delete'])->name('buku.delete');

//penulis



Route::get('/penulis', [PenulisController::class, 'index'])->name('Penulis');
Route::get('/creat_penulis', [PenulisController::class, 'create'])->name('create_penulis');
Route::post('/penulis', [PenulisController::class, 'store'])->name('action.create_penulis');
Route::get('/penulis/edit/{penulis_id}', [PenulisController::class, 'edit'])->name('edit_penulis');
Route::patch('/penulis/{penulis_id}', [PenulisController::class, 'update'])->name('update_penulis');
Route::delete('/penulis/{penulis_id}', [PenulisController::class, 'delete'])->name('delete_penulis');

//peminjaman

Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
Route::get('/peminjaman/{id}/status', [PeminjamanController::class, 'status'])->name('peminjaman.status');
Route::put('/peminjaman/{id}/update-status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.update-status');


//user

Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/create_user', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{user_id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{user_id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{user_id}', [UserController::class, 'destroy'])->name('user.destroy');

//rak

Route::get('/rak', [RakController::class, 'index'])->name('rak.index');
Route::get('/create_rak', [RakController::class, 'create'])->name('rak.create');
Route::post('/rak', [RakController::class, 'store'])->name('rak.store');
Route::get('/rak/{rak}/edit', [RakController::class, 'edit'])->name('rak.edit');
Route::put('/rak/{rak}', [RakController::class, 'update'])->name('rak.update');
Route::delete('/rak/{rak}', [RakController::class, 'destroy'])->name('rak.destroy');
