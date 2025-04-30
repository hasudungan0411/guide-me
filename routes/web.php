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
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\Wisatawan\DestinasiController as wisatawanDestinasiController;
use App\Http\Controllers\Wisatawan\HomeController as WisatawanHomeController;
use App\Http\Controllers\Wisatawan\BlogController as wisatawanBlogController;
use App\Http\Controllers\Wisatawan\GaleriController as wisatawanGaleriController;
use App\Http\Controllers\Wisatawan\ChatbotController as wisatawanChatbotController;
use App\Http\Controllers\Wisatawan\AcaraController as wisatawanAcaraController;
use App\Http\Controllers\Wisatawan\KategoriController as wisatawanKategoriController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('/wisatawan/home', [WisatawanHomeController::class, 'index'])->name('wisatawan.home');
Route::get('/wisatawan/destinasi', [WisatawanDestinasiController::class, 'destinasi'])->name('wisatawan.destinasi');
Route::get('/wisatawan/destinasi/detail_destinasi/{id}', [WisatawanDestinasiController::class, 'detail_destinasi'])->name('wisatawan.detail_destinasi');
Route::get('/wisatawan/blog', [wisatawanBlogController::class, 'blog'])->name('wisatawan.blog');
Route::get('/wisatawan/blog/{slug}', [WisatawanBlogController::class, 'blogdetail'])->name('wisatawan.blog-detail');
Route::get('/wisatawan/blog/blog-kategori/{id_kategori}', [WisatawanBlogController::class, 'blogKategori'])->name('wisatawan.blog-kategori');
Route::get('/wisatawan/galeri', [wisatawanGaleriController::class, 'galeri'])->name('wisatawan.galeri');
Route::get('//wisatawan/chatbot', [wisatawanChatbotController::class, 'chatbot'])->name('wisatawan.chatbot');
Route::get('//wisatawan/acara', [wisatawanAcaraController::class, 'acara'])->name('wisatawan.acara');
Route::get('//wisatawan/kategori/kategori-destinasi', [wisatawanKategoriController::class, 'destinasi'])->name('wisatawan.kategori-destinasi');
Route::get('/wisatawan/kategori/destinasi/{id_kategori}', [WisatawanKategoriController::class, 'destinasiByKategori'])->name('wisatawan.destinasi-by-kategori');
Route::get('//wisatawan/kategori/kategori-blog', [wisatawanKategoriController::class, 'blog'])->name('wisatawan.kategori-blog');

// Rute register wisatawan dan pemilik wisata
Route::get('/register', [AuthController::class, 'showregister']);
Route::post('/register/pengguna', [AuthController::class, 'register'])->name('register');

// Rute login user
Route::get('/login', [AuthController::class, 'showlogin'])->name('user.login');
Route::post('/login/pengguna', [AuthController::class, 'login'])->name('login');



//rute wisatawan
Route::prefix('wisatawan')->middleware(['auth:wisatawan'])->group(function () {
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
});


// Rute login pemilik destinasi wisata
Route::prefix('pemilik')->middleware(['auth:pemilikwisata'])->group(function () {
    Route::get('/index', [PemilikController::class, 'index'])->name('pemilik.index');
    Route::get('/tempat_wisata/{id}', [PemilikController::class, 'showtempatwisata'])->name('pemilik.tempatwisata');
    Route::get('/acara/{id}', [PemilikController::class, 'showacarapemilik'])->name('pemilik.acara');
    Route::get('/tiket/{id}', [PemilikController::class, 'showtiketpemilik'])->name('pemilik.tiket');
    Route::get('/transaksi/{id}', [PemilikController::class, 'showtransaksipemilik'])->name('pemilik.transaksi');
    Route::get('/logout', [PemilikController::class, 'logout'])->name('pemilik.logout');
});

Auth::routes(['verify' => true]);
