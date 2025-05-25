<?php

use App\Http\Controllers\TransaksiController;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\layoutscontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KelolaSaranController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\KelolaAkunPemilikController;
use App\Http\Controllers\WisataSearchController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\Wisatawan\DestinasiController as wisatawanDestinasiController;
use App\Http\Controllers\Wisatawan\HomeController as WisatawanHomeController;
use App\Http\Controllers\Wisatawan\BlogController as wisatawanBlogController;
use App\Http\Controllers\Wisatawan\GaleriController as wisatawanGaleriController;
use App\Http\Controllers\Wisatawan\ChatbotController as wisatawanChatbotController;
use App\Http\Controllers\Wisatawan\AcaraController as wisatawanAcaraController;
use App\Http\Controllers\Wisatawan\KategoriController as wisatawanKategoriController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WisatawanAuthController as WisatawanAuthController;
use App\Http\Controllers\Auth\PemilikWisataAuthController as PemilikWisataAuthController;
use App\Http\Controllers\Wisatawan\FavoritController as wisatawanFavoritController;

// Rute login admin
Route::get('/admin-login', [AdminController::class, 'showlogin'])->name('admin.login');
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

    // Rute Kelola Akun Pemilik
    Route::get('/kelola-akun-pemilik-wisata', [KelolaAkunPemilikController::class, 'pemilik_wisata'])->name('akun_pemilik-wisata.index');
    Route::get('/kelola-akun-pemilik-wisata/create', [KelolaAkunPemilikController::class, 'create'])->name('akun_pemilik-wisata.create');
    Route::post('/kelola-akun-pemilik-wisata/store', [KelolaAkunPemilikController::class, 'store'])->name('akun_pemilik-wisata.store');
    Route::delete('/kelola-akun-pemilik-wisata/{ID_Pemilik_Wisata}', [KelolaAkunPemilikController::class, 'destroy'])->name('akun_pemilik-wisata.destroy');

    // Rute kelola akun wisatawan
    Route::get('/kelola-akun-wisatawan', [KelolaAkunController::class, 'wisatawan'])->name('akun_wisatawan.index');
    // Tambah Wisatawan
    Route::get('/kelola-akun-wisatawan/create', [KelolaAkunController::class, 'createWisatawan'])->name('akun_wisatawan.create');
    // Simpan Wisatawan Baru
    Route::post('/kelola-akun-wisatawan/store', [KelolaAkunController::class, 'storeWisatawan'])->name('akun_wisatawan.store');
    // Hapus Wisatawan
    Route::delete('/kelola-akun-wisatawan/{ID_Wisatawan}', [KelolaAkunController::class, 'destroyWisatawan'])->name('akun_wisatawan.destroy');

});


// Halaman umum wisatawan tanpa login
Route::get('/', [WisatawanHomeController::class, 'index'])->name('wisatawan.home');
Route::prefix('wisatawan')->group(function () {
    Route::get('/', [WisatawanHomeController::class, 'index'])->name('wisatawan.home');
    Route::get('/home', [WisatawanHomeController::class, 'index'])->name('wisatawan.home');
    Route::get('/destinasi', [WisatawanDestinasiController::class, 'destinasi'])->name('wisatawan.destinasi');
    Route::get('/destinasi/detail_destinasi/{id}', [WisatawanDestinasiController::class, 'detail_destinasi'])->name('wisatawan.detail_destinasi');
    Route::get('/blog', [WisatawanBlogController::class, 'blog'])->name('wisatawan.blog');
    Route::get('/blog/{slug}', [WisatawanBlogController::class, 'blogdetail'])->name('wisatawan.blog-detail');
    Route::get('/blog/blog-kategori/{id_kategori}', [WisatawanBlogController::class, 'blogKategori'])->name('wisatawan.blog-kategori');
    Route::get('/galeri', [WisatawanGaleriController::class, 'galeri'])->name('wisatawan.galeri');
    Route::get('/acara', [WisatawanAcaraController::class, 'acara'])->name('wisatawan.acara');
    Route::get('/acara/{ID_Acara}', [WisatawanAcaraController::class, 'show'])->name('wisatawan.acara-detail');
    Route::get('/kategori/kategori-destinasi', [WisatawanKategoriController::class, 'destinasi'])->name('wisatawan.kategori-destinasi');
    Route::get('/kategori/destinasi/{id_kategori}', [WisatawanKategoriController::class, 'destinasiByKategori'])->name('wisatawan.destinasi-by-kategori');
    Route::get('/chatbot', [WisatawanChatbotController::class, 'chatbot'])->name('wisatawan.chatbot');
    Route::post('/send', [WisatawanChatbotController::class, 'sendChat']);
    Route::get('/search', [WisataSearchController::class, 'search'])->name('wisatawan.search');
});
// ======== AUTH WISATAWAN ========
Route::prefix('wisatawan')->group(function () {
    Route::get('/Masuk', [WisatawanAuthController::class, 'login'])->name('wisatawan.login');
    Route::post('/login', [WisatawanAuthController::class, 'loginPost']);
    Route::get('/auth/google', [WisatawanAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/GuideMe/masuk/callback', [WisatawanAuthController::class, 'handleGoogleCallback']);
    Route::get('/Daftar-akun', [WisatawanAuthController::class, 'register'])->name('wisatawan.register');
    Route::post('/register', [WisatawanAuthController::class, 'registerPost'])->name('wisatawan.registerPost');
    Route::post('/logout', [WisatawanAuthController::class, 'logout'])->name('wisatawan.logout');

    // fitur wajib login
    Route::middleware(['auth:wisatawan'])->group(function () {
        Route::post('/destinasi/detail_destinasi/', [TransaksiController::class, 'pesan'])->name('pesan.tiket');
        // Route::post('/ulasan', [WisatawanReviewController::class, 'store'])->name('wisatawan.ulasan');
        Route::get('/favorit', [WisatawanFavoritController::class, 'index'])->name('wisatawan.favorit');
        Route::post('/favorit/toggle/{id}', [WisatawanFavoritController::class, 'toggleFavorit']);
        Route::post('/pesan-tiket', [TransaksiController::class, 'pesan'])->name('wisatawan.pesan');
    });
});

// ======== AUTH Pemilik ========
Route::prefix('pemilik')->group(function () {
    Route::get('/login', [PemilikWisataAuthController::class, 'showLoginForm'])->name('pemilik.login');
    Route::post('/login', [PemilikWisataAuthController::class, 'login']);
    Route::post('/logout', [PemilikWisataAuthController::class, 'logout'])->name('pemilik.logout');

    Route::middleware(['auth:pemilikwisata'])->group(function () {
        // Index
        Route::get('/', [PemilikController::class, 'index'])->name('pemilik.index');
        Route::get('/index', [PemilikController::class, 'index'])->name('pemilik.index');

        // Acara
        Route::get('/acara', [AcaraController::class, 'index'])->name('pemilik.acara');
        Route::get('/acara/create', [AcaraController::class, 'create'])->name('acara.create');
        Route::post('/acara/create', [AcaraController::class, 'store'])->name('acara.store');
        Route::get('/acara/edit/{id}', [AcaraController::class, 'edit'])->name('acara.edit');
        Route::post('/acara/update/{id}', [AcaraController::class, 'update'])->name('acara.update');
        Route::get('/acara/delete/{id}', [AcaraController::class, 'destroy'])->name('acara.destroy');

        // Tiket
        Route::get('/tiket', [TiketController::class, 'index'])->name('pemilik.tiket');
        Route::put('/tiket/update', [TiketController::class, 'update'])->name('tiket.update');


        // Transaksi
        Route::get('/transaksi', [TransaksiController::class, 'showtransaksipemilik'])->name('pemilik.transaksi');
        Route::put('/transaksi/konfirmasi/{id}', [TransaksiController::class, 'konfirmasitiket'])->name('tiket.konfirmasi');
        Route::put('/transaksi/gunakan/{id}', [TransaksiController::class, 'gunakantiket'])->name('tiket.gunakan');
        Route::delete('/transaksi/hapus/{id}', [TransaksiController::class, 'hapustiket'])->name('tiket.hapus');


    });
});
