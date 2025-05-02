<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\layoutscontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KelolaSaranController;
use App\Http\Controllers\KelolaAkunController;
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
use App\Http\Controllers\Auth\PemilikEmailVerificationController;
use Illuminate\Support\Facades\Auth;

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
Route::get('/wisatawan/chatbot', [wisatawanChatbotController::class, 'chatbot'])->name('wisatawan.chatbot');
Route::get('/wisatawan/acara', [wisatawanAcaraController::class, 'acara'])->name('wisatawan.acara');
Route::get('/wisatawan/kategori/kategori-destinasi', [wisatawanKategoriController::class, 'destinasi'])->name('wisatawan.kategori-destinasi');
Route::get('/wisatawan/kategori/destinasi/{id_kategori}', [WisatawanKategoriController::class, 'destinasiByKategori'])->name('wisatawan.destinasi-by-kategori');
Route::get('/wisatawan/kategori/kategori-blog', [wisatawanKategoriController::class, 'blog'])->name('wisatawan.kategori-blog');


Route::get('/pemilik/index', [PemilikController::class, 'index'])->name('pemilik.index');

Route::get('/pemilik/tempat_wisata/{id}', [PemilikController::class, 'showtempatwisata'])->name('pemilik.tempatwisata');

Route::get('/pemilik/acara/{id}', [PemilikController::class, 'showacarapemilik'])->name('pemilik.acara');
Route::get('/pemilik/acara/create', [PemilikController::class, 'createacara'])->name('acara.create');

Route::get('/pemilik/tiket/{id}', [PemilikController::class, 'showtiketpemilik'])->name('pemilik.tiket');
Route::get('/pemilik/transaksi/{id}', [PemilikController::class, 'showtransaksipemilik'])->name('pemilik.transaksi');


// ======== AUTH WISATAWAN ========
Route::prefix('wisatawan')->group(function () {
    Route::get('/login', [WisatawanAuthController::class, 'showLogin'])->name('wisatawan.login');
    Route::post('/login', [WisatawanAuthController::class, 'login']);
    Route::get('/register', [WisatawanAuthController::class, 'showRegister'])->name('wisatawan.register');
    Route::post('/register', [WisatawanAuthController::class, 'register']);
    Route::post('/logout', [WisatawanAuthController::class, 'logout'])->name('wisatawan.logout');

    Route::middleware(['auth:wisatawan'])->group(function () {
        Route::get('/dashboard', fn() => view('wisatawan.dashboard'))->name('wisatawan.dashboard');
    });
});

Route::prefix('pemilik')->group(function () {
    // Login
    Route::get('/login', [PemilikWisataAuthController::class, 'showLogin'])->name('pemilikwisata.login');
    Route::post('/login', [PemilikWisataAuthController::class, 'login']);

    // Register
    Route::get('/register', [PemilikWisataAuthController::class, 'showRegister'])->name('pemilikwisata.register');
    Route::post('/register', [PemilikWisataAuthController::class, 'register']);

    // Logout
    Route::post('/logout', [PemilikWisataAuthController::class, 'logout'])->name('pemilikwisata.logout');

    // Verifikasi Email
    Route::get('/verifikasi', function () {
        return view('pemilik.verify-email');
    })->name('pemilikwisata.verifikasi');

    Route::post('/verifikasi/kirim-ulang', function (Request $request) {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::guard('pemilikwisata')->user();

        // Cek apakah pengguna sudah login
        if (!$user) {
            return back()->with('error', 'Anda belum login.');
        }

        // Cek apakah email sudah diverifikasi
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email Anda sudah diverifikasi.');
        }

        // Jika email belum diverifikasi, kirimkan email verifikasi ulang
        try {
            $user->sendEmailVerificationNotification();
            return back()->with('success', 'Link verifikasi telah dikirim ulang.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi.');
        }
    })->middleware('pemilikwisata')->name('pemilikwisata.verifikasi.resend');

    // Verifikasi URL untuk mengonfirmasi email
    Route::get('/email/verify/{id}/{hash}', [PemilikEmailVerificationController::class, 'verify'])
        ->middleware(['signed'])
        ->name('verification.verify');

    // Verifikasi Berhasil
    Route::get('/verifikasi/berhasil', fn() => view('pemilik.verified-success'))->name('pemilikwisata.verified');

    // Middleware untuk memeriksa login dan verifikasi email
    Route::middleware(['pemilikwisata', 'verified.p'])->group(function () {
        Route::get('/dashboard', fn() => view('pemilik.dashboard'))->name('pemilik.index');
    });
});
