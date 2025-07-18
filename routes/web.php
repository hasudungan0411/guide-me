<?php

use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\layoutscontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\KelolaAkunController;
use App\Http\Controllers\KelolaAkunPemilikController;
use App\Http\Controllers\WisataSearchController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifikasiEmailController;
use App\Http\Controllers\Wisatawan\UlasanController;
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
Route::get('/admin-login-guide25', [AdminController::class, 'showlogin'])->name('admin.login');
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

    Route::get('/transaksi', [TransaksiController::class, 'adminIndex'])->name('admin.transaksi');

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
    Route::post('/chatbot/send', [WisatawanChatbotController::class, 'sendMessage']);
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

    Route::get('/register/verifikasi', [WisatawanAuthController::class, 'showOtpForm'])->name('wisatawan.otp.form');
    Route::post('/register/verifikasi', [WisatawanAuthController::class, 'verifyEmail'])->name('wisatawan.otp.verify');

    Route::post('/logout', [WisatawanAuthController::class, 'logout'])->name('wisatawan.logout');
    // Reset Password
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('wisatawan.password.request');
    // Kirim email reset password
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('wisatawan.password.email');
    // Form reset password dengan token
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('wisatawan.password.reset');
    // Submit form reset password (update password)
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('wisatawan.password.update');

    // rute tampilan ulasan
    Route::get('/destinasi/{destinationId}/load-more-ulasan', [UlasanController::class, 'loadMoreUlasan'])->name('wisatawan.loadMoreUlasan');

    // fitur wajib login
    Route::middleware(['auth:wisatawan'])->group(function () {

        Route::post('/ulasan/{id_destinasi}', [UlasanController::class, 'store'])->name('wisatawan.ulasan.store');

        Route::get('/favorit', [WisatawanFavoritController::class, 'index'])->name('wisatawan.favorit');
        Route::post('/favorit/toggle/{id}', [WisatawanFavoritController::class, 'toggleFavorit']);
        Route::post('/pesan-tiket', [TransaksiController::class, 'pesan'])->name('wisatawan.pesan');

        // Tiket Wisatawan
        // Route::post('/destinasi/detail_destinasi/', [TransaksiController::class, 'pesan'])->name('pesan.tiket');
        Route::get('/pesanan', [TransaksiController::class, 'showpesananwisatawan'])->name('wisatawan.pesanan');
        Route::post('/pesanan/upload/{id}', [TransaksiController::class, 'uploadbukti'])->name('upload.bukti');
        Route::get('/pesanan/detail/{id}', [TransaksiController::class, 'showdetailtiket'])->name('wisatawan.tiket-detail');
        Route::get('/pesanan/konfirmasi', [TransaksiController::class, 'showKonfirmasi'])->name('wisatawan.konfirmasi');
        Route::post('/pesanan/konfirmasi', [TransaksiController::class, 'pesan'])->name('konfirmasi.pesanan');
        Route::post('/pesanan/batal', [TransaksiController::class, 'batalPesanan'])->name('batal.pesanan');
        Route::get('pesanan/invoice/{id}', [TransaksiController::class, 'generateInvoicePDF'])->name('wisatawan.invoice');

        Route::get('/rekomendasi', [RekomendasiController::class, 'rekomendasiTopK']);

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
        Route::get('/acara', [AcaraController::class, 'index'])->name('pemilik.acara.index');
        Route::get('/acara/create', [AcaraController::class, 'create'])->name('pemilik.acara.create');
        Route::post('/acara/create', [AcaraController::class, 'store'])->name('pemilik.acara.store');
        Route::get('/acara/edit/{ID_Acara}', [AcaraController::class, 'edit'])->name('pemilik.acara.edit');
        Route::put('/acara/update/{ID_Acara}', [AcaraController::class, 'update'])->name('pemilik.acara.update');
        Route::delete('/acara/delete/{ID_Acara}', [AcaraController::class, 'destroy'])->name('pemilik.acara.destroy');

        // Tiket
        Route::get('/tiket', [TiketController::class, 'index'])->name('pemilik.tiket');
        Route::put('/tiket/update', [TiketController::class, 'update'])->name('tiket.update');


        // Transaksii
        Route::get('/transaksi', [TransaksiController::class, 'showtransaksipemilik'])->name('pemilik.transaksi');
        Route::put('/transaksi/update/rekening', [TransaksiController::class, 'updateRekening'])->name('pemilik.rekening_update');
        Route::put('/transaksi/konfirmasi/{id}', [TransaksiController::class, 'konfirmasitiket'])->name('tiket.konfirmasi');
        Route::put('/transaksi/gunakan/{id}', [TransaksiController::class, 'gunakantiket'])->name('tiket.gunakan');
        Route::delete('/transaksi/hapus/{id}', [TransaksiController::class, 'hapustiket'])->name('tiket.hapus');
    });
});
