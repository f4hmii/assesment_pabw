<?php

use Illuminate\Support\Facades\Route;
// 💡 BARIS INI WAJIB ADA UNTUK MENEMUKAN CONTROLLER ANDA
use App\Http\Controllers\ProductController;

// Route untuk halaman utama ('/'), akan langsung dialihkan ke halaman daftar produk
Route::get('/', function () {
    return redirect()->route('products.index');
});

// -- ROUTE UNTUK CREATE & READ (YANG SUDAH ANDA BUAT) --

// Route untuk menampilkan semua produk (READ)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route untuk menampilkan form tambah produk (CREATE - Tampilan Form)
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Route untuk memproses penyimpanan produk baru (CREATE - Proses Simpan)
Route::post('/products', [ProductController::class, 'store'])->name('products.store');


// -- ROUTE UNTUK UPDATE & DELETE (YANG DITAMBAHKAN) --

// Route untuk menampilkan form edit produk (UPDATE - Tampilan Form)
// {product} adalah parameter untuk ID/index produk yang akan diedit
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// Route untuk memproses pembaruan data produk (UPDATE - Proses Simpan)
// Menggunakan method PUT untuk update, sesuai standar RESTful
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Route untuk menghapus produk (DELETE - Proses Hapus)
// Menggunakan method DELETE untuk hapus, sesuai standar RESTful
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
