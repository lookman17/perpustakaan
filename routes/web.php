<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\{
    RoutesController,
    RequestController,
    LoginController,
    BookController,
    PagesController,
    PenerbitController,
    KategoriController,
    BukuController,
    PenulisController,
    PeminjamanController,
    UserController,
    RakController
};

// Halaman Login dan Registrasi (tidak memerlukan auth)
Route::get('/login', [PagesController::class, 'login'])->name('login');
Route::post('/user/login', [UserController::class, 'login'])->name('user.login');
Route::get('/register', [PagesController::class, 'register'])->name('register');
Route::post('/user/register', [UserController::class, 'register'])->name('user.register');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


// Proteksi semua halaman dengan middleware 'auth'
Route::middleware(['web', 'auth', 'role:admin'])->group(function () {
    // Halaman Siswa dan Admin
    Route::get('/admin_buku', [PagesController::class, 'adminBuku'])->name('adminBuku');
    Route::get('/admin_peminjam', [PagesController::class, 'adminPeminjam'])->name('adminPeminjam');
    Route::get('/pengaturan', [PagesController::class, 'Pengaturan'])->name('Pengaturan');
    Route::get('/pengaturan_admin', [PagesController::class, 'adminPengaturan'])->name('adminPengaturan');

    // Modul Penerbit
    Route::prefix('penerbit')->group(function () {
        Route::get('/', [PagesController::class, 'penerbit'])->name('Penerbit');
        Route::get('/create', [PagesController::class, 'create_penerbit'])->name('create_penerbit');
        Route::post('/', [PenerbitController::class, 'create'])->name('action.createpenerbit');
        Route::get('/update/{penerbit_id}', [PagesController::class, 'update_penerbit'])->name('update_penerbit');
        Route::patch('/{penerbit_id}', [PenerbitController::class, 'update'])->name('penerbit.update');
        Route::delete('/{penerbit_id}', [PenerbitController::class, 'delete'])->name('penerbit.delete');
    });

    // Modul Kategori
    Route::prefix('kategori')->group(function () {
        Route::get('/buku', [PagesController::class, 'kategoriBuku'])->name('kategoriBuku');
        Route::get('/create', [PagesController::class, 'create'])->name('create_kategori_buku');
        Route::post('/', [KategoriController::class, 'create'])->name('action.createkategoribuku');
        Route::get('/update/{kategori_id}', [PagesController::class, 'update_kategori'])->name('update_kategori');
        Route::patch('/{kategori_id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/{kategori_id}', [KategoriController::class, 'delete'])->name('kategori.delete');
    });

    // Modul Buku
    Route::prefix('buku')->group(function () {
        Route::get('/', [BukuController::class, 'index'])->name('buku');
        Route::get('/create', [BukuController::class, 'create'])->name('create_buku');
        Route::post('/', [BukuController::class, 'store'])->name('action.create_buku');
        Route::get('/update/{buku_id}', [BukuController::class, 'edit'])->name('update_buku');
        Route::patch('/{buku_id}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/{buku_id}', [BukuController::class, 'delete'])->name('buku.delete');



    });

    // Modul Penulis
    Route::prefix('penulis')->group(function () {
        Route::get('/', [PenulisController::class, 'index'])->name('Penulis');
        Route::get('/create', [PenulisController::class, 'create'])->name('create_penulis');
        Route::post('/', [PenulisController::class, 'store'])->name('action.create_penulis');
        Route::get('/edit/{penulis_id}', [PenulisController::class, 'edit'])->name('edit_penulis');
        Route::patch('/{penulis_id}', [PenulisController::class, 'update'])->name('update_penulis');
        Route::delete('/{penulis_id}', [PenulisController::class, 'delete'])->name('delete_penulis');
    });

    // Modul Peminjaman
    Route::prefix('peminjaman')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('peminjaman');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
        Route::put('/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
        Route::delete('/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        Route::get('/{id}/status', [PeminjamanController::class, 'status'])->name('peminjaman.status');
        Route::get('/buku/pinjam/{buku_id}', [PeminjamanController::class, 'pinjam'])->name('buku.pinjam');
        Route::put('/{id}/update-status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.update-status');
    });

    // Modul Rak
    Route::prefix('rak')->group(function () {
        Route::get('/', [RakController::class, 'index'])->name('rak.index');
        Route::get('/create', [RakController::class, 'create'])->name('rak.create');
        Route::post('/', [RakController::class, 'store'])->name('rak.store');
        Route::get('/{rak_id}/edit', [RakController::class, 'edit'])->name('rak.edit');
        Route::put('/{rak_id}', [RakController::class, 'update'])->name('rak.update');
        Route::delete('/{rak_id}', [RakController::class, 'delete'])->name('rak.delete');


    });
    Route::get('/admin', [PagesController::class, 'dashboardAdmin'])->name('dashboardAdmin');


});
Route::middleware(['web', 'auth', 'role:anggota'])->group(function () {
    Route::get('/dashboardsiswa', [PagesController::class, 'dashboard'])->name('dashboard');
    Route::get('/siswa_buku', [PagesController::class, 'bukuSiswa'])->name('bukuSiswa');
    Route::get('/create/siswa', [PeminjamanController::class, 'buat'])->name('peminjaman.buat');
    Route::get('/siswa', [PeminjamanController::class, 'siswa'])->name('peminjaman.siswa');
    Route::get('/siswa/buku', [BukuController::class, 'siswa'])->name('siswa.buku');
    Route::get('pengaturan',[PagesController::class, 'Pengaturan'])->name('pengaturan');
    Route::patch('user/{id}/update_profile', [UserController::class, 'upload_profile'])->name('action.upload_profile');
});
