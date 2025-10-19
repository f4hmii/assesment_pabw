<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestimoniController;


// Halaman utama dialihkan ke daftar produk
Route::get('/', function () {
    return redirect()->route('products.index');
});

// READ - Menampilkan semua produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// CREATE - Form tambah produk
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// CREATE - Proses simpan produk baru
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// UPDATE - Form edit produk
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

// UPDATE - Proses simpan perubahan produk
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// DELETE - Hapus produk
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

// FILTER - Menyaring produk berdasarkan kategori/harga
Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');

// SEARCH - Mencari produk berdasarkan nama/kategori
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
Route::put('/testimoni/{id}', [TestimoniController::class, 'update'])->name('testimoni.update');
Route::delete('/testimoni/{id}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
