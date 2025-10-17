<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $products = session()->get('products', []);
        // DIUBAH: Langsung memanggil 'index' dari folder views
        return view('index', ['products' => $products]);
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        // DIUBAH: Langsung memanggil 'create' dari folder views
        return view('create');
    }

    /**
     * Menyimpan produk baru ke dalam array di session.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|min:3',
            'harga' => 'required|integer',
        ]);

        // Siapkan data produk baru
        $newProduct = [
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
        ];

        // Ambil data produk yang sudah ada dari session
        $products = session()->get('products', []);

        // Tambahkan produk baru ke dalam array
        $products[] = $newProduct;

        // Simpan kembali array yang sudah diperbarui ke dalam session
        session()->put('products', $products);

        // Arahkan kembali ke halaman daftar produk dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }
}

