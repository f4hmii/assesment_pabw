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
        // Mengirimkan index produk sebagai 'id' ke view agar bisa digunakan untuk link edit/delete
        $productsWithId = array_map(function ($product, $index) {
            $product['id'] = $index;
            return $product;
        }, $products, array_keys($products));

        return view('index', ['products' => $productsWithId]);
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Menyimpan produk baru ke dalam array di session.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:3',
            'harga' => 'required|integer|min:0',
        ]);

        $newProduct = [
            'nama' => $request->input('nama'),
            'harga' => (int) $request->input('harga'),
        ];

        $products = session()->get('products', []);
        $products[] = $newProduct;
        session()->put('products', $products);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     * @param int $id Index produk dalam array session
     */
    public function edit(int $id)
    {
        $products = session()->get('products', []);

        if (!isset($products[$id])) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan!');
        }

        $product = $products[$id];
        $product['id'] = $id; // Sertakan index/id ke view

        return view('edit', ['product' => $product]);
    }

    /**
     * Memperbarui produk di dalam session.
     * @param Request $request
     * @param int $id Index produk dalam array session
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama' => 'required|string|min:3',
            'harga' => 'required|integer|min:0',
        ]);

        $products = session()->get('products', []);

        if (!isset($products[$id])) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan!');
        }

        $products[$id] = [
            'nama' => $request->input('nama'),
            'harga' => (int) $request->input('harga'),
        ];

        session()->put('products', $products);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari session.
     * @param int $id Index produk dalam array session
     */
    public function destroy(int $id)
    {
        $products = session()->get('products', []);

        if (!isset($products[$id])) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan!');
        }

        // Gunakan array_splice untuk menghapus dan mengurutkan ulang index
        array_splice($products, $id, 1);

        session()->put('products', $products);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}