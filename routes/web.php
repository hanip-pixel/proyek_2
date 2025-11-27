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

Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ROUTES KERANJANG LANGSUNG
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::get('/keranjang/tambah/{key}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::get('/keranjang/kurang/{key}', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
Route::get('/keranjang/hapus/{key}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');

// Route untuk transaksi biasa
Route::get('/transaksi', [TransaksiController::class, 'showWithQuery'])->name('transaksi.show.query');
Route::get('/transaksi/{id}/{tabel}', [TransaksiController::class, 'show'])->name('transaksi.show');
Route::post('/transaksi/{id}/{tabel}/ulasan', [TransaksiController::class, 'storeUlasan'])->name('transaksi.ulasan.store');

// Route untuk transaksi lanjut
Route::get('/transaksi-lanjut', [TransaksiController::class, 'showLanjut'])->name('transaksi.lanjut');
Route::post('/transaksi/proses', [TransaksiController::class, 'prosesPembelian'])->name('transaksi.proses');
Route::get('/transaksi/sukses/{id}', [TransaksiController::class, 'suksesPembelian'])->name('transaksi.sukses');

// Tambahkan route untuk riwayat
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');

Route::get('/about', [AboutController::class, 'index'])->name('about')->middleware('auth');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Forgot Password Routes
Route::get('/lupa-sandi', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/lupa-sandi', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');