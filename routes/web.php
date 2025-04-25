<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\layoutscontroller;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\SaranController;
use App\Http\Controllers\WisatawanController;
use App\Http\Controllers\PemilikwisataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
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

    // Routes untuk Saran Tempat Wisata
    Route::resource('saran', SaranController::class);

    // Routes untuk Kelola Wisatawan
    Route::resource('wisatawan', WisatawanController::class);

    // Routes untuk Kelola Pemilik Wisata
    Route::resource('pemilik-wisata', PemilikwisataController::class);
});


// Rute register user dan pemilik wisata
Route::get('/user/register', [AuthController::class, 'showregister']);
Route::post('/user/register', [AuthController::class, 'register'])->name('register');

// Rute login user
Route::get('/pengguna', [AuthController::class, 'showlogin'])->name('user.login');
Route::post('/pengguna/login', [AuthController::class, 'login'])->name('login');



//rute wisatawan
Route::prefix('wisatawan')->middleware(['auth:wisatawan'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
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
