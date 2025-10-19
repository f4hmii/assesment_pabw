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
        // Ambil produk, kategori, dan testimoni dari session (default ke array kosong)
        $products = session()->get('products', []);
        $categories = session()->get('categories', []);     // tambah jika view menggunakan $categories
        $testimonis = session()->get('testimonis', []);     // penting — supaya $testimonis tidak undefined

        // Menambahkan index sebagai id untuk tiap produk agar bisa dipakai untuk edit/delete
        $productsWithId = array_map(function ($product, $index) {
            $product['id'] = $index;
            return $product;
        }, $products, array_keys($products));

        // Kirim semua variabel yang dibutuhkan ke view index
        return view('index', [
            'products' => $productsWithId,
            'categories' => $categories,
            'testimonis' => $testimonis,
        ]);
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
        $category = $product['category'] ?? null;

        // return view('edit', ['product' => $product]); ---kode fahmi---
        return view('edit', ['product' => $product, 'category' => $category]);
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
            // kode fairuz: validasi kategori
            'category' => 'nullable|string',
            // selesai

        ]);

        $products = session()->get('products', []);

        if (!isset($products[$id])) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan!');
        }

        $products[$id] = [
            'nama' => $request->input('nama'),
            'harga' => (int) $request->input('harga'),
            'category' => $request->input('category', null),
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

    /**
     * Halaman untuk memfilter produk berdasarkan kategori dan harga.
     * kode fairuz
     */
    public function filter(Request $request)
    {
        // Ambil semua produk dari session
        $products = session()->get('products', []);

        // Ambil input filter dari form
        $category = $request->input('category');
        $maxPrice = $request->input('maxPrice');

        // Filter berdasarkan kategori (jika diisi)
        if ($category) {
            $products = array_filter($products, function ($product) use ($category) {
                return isset($product['category']) && strtolower($product['category']) === strtolower($category);
            });
        }

        // Filter berdasarkan harga maksimal (jika diisi)
        if ($maxPrice) {
            $products = array_filter($products, function ($product) use ($maxPrice) {
                return isset($product['harga']) && $product['harga'] <= $maxPrice;
            });
        }

        // Tambahkan ID index agar bisa ditampilkan
        $productsWithId = array_map(function ($product, $index) {
            $product['id'] = $index;
            return $product;
        }, $products, array_keys($products));

        // Kirim data ke view filter
        return view('filter', [
            'products' => $productsWithId,
            'category' => $category,
            'maxPrice' => $maxPrice

        ]);
    }
    /**
     * Mencari produk berdasarkan nama atau kategori.
     */
    public function search(Request $request)
    {
        // Ambil semua produk dari session
        $products = session()->get('products', []);

        // Ambil input pencarian dari form
        $keyword = $request->input('keyword');

        // Jika ada keyword, filter produk
        if ($keyword) {
            $products = array_filter($products, function ($product) use ($keyword) {
                return stripos($product['nama'], $keyword) !== false ||
                    (isset($product['category']) && stripos($product['category'], $keyword) !== false);
            });
        }

        // Tambahkan ID index agar bisa digunakan untuk edit/delete
        $productsWithId = array_map(function ($product, $index) {
            $product['id'] = $index;
            return $product;
        }, $products, array_keys($products));

        // Kembalikan ke view index dengan hasil pencarian
        return view('index', [
            'products' => $productsWithId,
            'keyword' => $keyword
        ]);
    }
    /**
     * CRUD sederhana untuk Customer
     * Contoh: Tambah dan tampilkan pelanggan
     */
    public function customers()
    {
        $customers = session()->get('customers', []);
        return view('customers.index', ['customers' => $customers]);
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:3',
            'email' => 'required|email'
        ]);

        $newCustomer = [
            'nama' => $request->input('nama'),
            'email' => $request->input('email')
        ];

        $customers = session()->get('customers', []);
        $customers[] = $newCustomer;
        session()->put('customers', $customers);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan!');
    }

    public function deleteCustomer($id)
    {
        $customers = session()->get('customers', []);

        if (!isset($customers[$id])) {
            return redirect()->route('customers.index')->with('error', 'Customer tidak ditemukan!');
        }

        array_splice($customers, $id, 1);
        session()->put('customers', $customers);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus!');
    }
}
