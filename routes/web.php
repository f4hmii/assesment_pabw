<?php

use Illuminate\Support\Facades\Route;
// 💡 BARIS INI WAJIB ADA UNTUK MENEMUKAN CONTROLLER ANDA
use App\Http\Controllers\ProductController; 

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Route untuk menampilkan semua produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route untuk menampilkan form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Route untuk memproses penyimpanan produk baru
Route::post('/products', [ProductController::class, 'store'])->name('products.store');