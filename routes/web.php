<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BalasanUlasanController;
use App\Http\Controllers\Admin\UlasanController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Tambahkan route ini di routes/web.php
Route::get('/filter-products', [HomeController::class, 'filterProducts'])->name('filter.products');

// ROUTES KERANJANG LANGSUNG
Route::prefix('keranjang')->group(function () {
    Route::get('/', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::get('/tambah/{key}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::get('/kurang/{key}', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
    Route::get('/hapus/{key}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
});

// Pastikan route ini ada
Route::get('/transaksi/{id}/{tabel}', [TransaksiController::class, 'show'])->name('transaksi.show');
Route::post('/transaksi/proses', [TransaksiController::class, 'prosesPembelian'])->name('transaksi.proses');
Route::get('/transaksi/lanjut', [TransaksiController::class, 'showLanjut'])->name('transaksi.lanjut');
Route::get('/transaksi', [TransaksiController::class, 'showWithQuery'])->name('transaksi.show.query');

// Route untuk transaksi lanjut
Route::get('/transaksi-lanjut', [TransaksiController::class, 'showLanjut'])->name('transaksi.lanjut');
Route::post('/transaksi/proses', [TransaksiController::class, 'prosesPembelian'])->name('transaksi.proses');
Route::get('/transaksi/sukses/{id}', [TransaksiController::class, 'suksesPembelian'])->name('transaksi.sukses');

// Tambahkan route untuk riwayat
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

Route::get('/about', [AboutController::class, 'index'])->name('about')->middleware('auth');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Profil Routes
Route::prefix('profil')->group(function () {
    Route::get('/', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/biodata', [ProfilController::class, 'biodata'])->name('profil.biodata');
    Route::get('/alamat', [ProfilController::class, 'alamat'])->name('profil.alamat');
    Route::post('/upload-foto', [ProfilController::class, 'uploadFoto'])->name('profil.uploadFoto');
    Route::post('/simpan-biodata', [ProfilController::class, 'simpanBiodata'])->name('profil.simpanBiodata');
    Route::post('/simpan-alamat', [ProfilController::class, 'simpanAlamat'])->name('profil.simpanAlamat');
});

// routes/web.php
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/transaksi/{id}/{tabel}', [TransaksiController::class, 'show'])->name('transaksi');
Route::get('/keranjang/tambah/{type}/{id}', [CartController::class, 'tambah'])->name('keranjang.tambah');

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Forgot Password Routes
Route::get('/lupa-sandi', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/lupa-sandi', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');

// Public Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

        Route::prefix('ulasan')->name('ulasan.')->group(function () {
        Route::get('/', [UlasanController::class, 'index'])->name('index');
        Route::post('/{id}/balasan', [UlasanController::class, 'storeBalasan'])->name('balasan.store');
        Route::delete('/{id}', [UlasanController::class, 'destroy'])->name('destroy');
        Route::delete('/balasan/{id}', [UlasanController::class, 'destroyBalasan'])->name('balasan.destroy');
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ✅ TAMBAHKAN ROUTE UNTUL ULASAN
Route::post('/transaksi/{id}/{tabel}/ulasan', [TransaksiController::class, 'storeUlasan'])->name('transaksi.ulasan.store');

// Redirect root to admin login
// Route::get('/', function () {
//     return redirect()->route('admin.login');
// });