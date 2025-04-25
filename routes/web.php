<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\layoutscontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KelolaSaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KelolaAkunController;
use Illuminate\Support\Facades\Route;


// Rute login admin
Route::get('/', [AdminController::class, 'showlogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.proses');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [layoutscontroller::class, 'admin'])->name('layouts.admin');

    Route::get('/destinasi/index', [DestinasiController::class, 'index'])->name('destinasi.index');
    Route::get('/destinasi/create', [DestinasiController::class, 'create'])->name('destinasi.create');
    Route::post('/destinasi/store', [DestinasiController::class, 'store'])->name('destinasi.store');
    Route::get('/destinasi/detail/{id}', [DestinasiController::class, 'show'])->name('destinasi.show');
    Route::get('/destinasi/edit/{id}', [DestinasiController::class, 'edit'])->name('destinasi.edit');
    Route::put('/destinasi/{id}', [DestinasiController::class, 'update'])->name('destinasi.update');
    Route::delete('/destinasi/delete/{id}', [DestinasiController::class, 'destroy'])->name('destinasi.destroy');

    Route::resource('kategori', KategoriController::class);

    Route::resource('blog', BlogController::class)->parameters([
        'blog' => 'slug'
    ]);

    Route::resource('galeri', GaleriController::class);

    // Routes untuk kolola Saran Tempat Wisata
    Route::get('/kelola-saran-wisata', [KelolaSaranController::class, 'saran'])->name('kelola_saranwisata.index');

    // Rute Kelola Akun 
    Route::get('/kelola-akun-pemilik-wisata', [KelolaAkunController::class, 'pemilik_wisata'])->name('akun_pemilik-wisata.index');
    Route::get('/kelola-akun-wisatawan', [KelolaAkunController::class, 'wisatawan'])->name('akun_wisatawan.index');
});

// Rute login wisatawan
Route::get('/wisatawan', [HomeController::class, 'wisatawan'])->name('layouts.wisatawan');
Route::get('/wisatawan/home', [HomeController::class, 'index'])->name('wisatawan.home');
Route::get('/wisatawan/destinasi', [HomeController::class, 'destinasi'])->name('wisatawan.destinasi');
Route::get('/wisatawan/destinasi/detail_destinasi/{id}', [HomeController::class, 'detail_destinasi'])->name('wisatawan.detail_destinasi');
Route::get('/wisatawan/blog', [HomeController::class, 'blog'])->name('wisatawan.blog');
Route::get('/wisatawan//blog/   blog-kategori/{id}', [HomeController::class, 'kategori'])->name('wisatawan.blog-kategori');
Route::get('/wisatawan/galeri', [HomeController::class, 'galeri'])->name('wisatawan.galeri');

// Rute register wisatawan dan pemilik wisata
Route::get('/register', [AuthController::class, 'showregister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');


// Rute login pemilik destinasi wisata
Route::get('/pemilik/login', [PemilikController::class, 'showlogin'])->name('pemilik.login');
Route::get('/pemilik', [PemilikController::class, 'logout'])->name('pemilik.logout');

Route::get('/pemilik/index', [PemilikController::class, 'index'])->name('pemilik.index');
Route::get('/pemilik/tempat_wisata/{id}', [PemilikController::class, 'showtempatwisata'])->name('pemilik.tempatwisata');
Route::get('/pemilik/acara/{id}', [PemilikController::class, 'showacarapemilik'])->name('pemilik.acara');
Route::get('/pemilik/tiket/{id}', [PemilikController::class, 'showtiketpemilik'])->name('pemilik.tiket');
Route::get('/pemilik/transaksi/{id}', [PemilikController::class, 'showtransaksipemilik'])->name('pemilik.transaksi');

