<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController
{
      // kode zulfahmi
    /*Menampilkan daftar semua produk. */
   public function index()
{
    // Ambil produk, kategori, dan testimoni dari session
    $products = session()->get('products', []);
    $categories = session()->get('categories', []);
    $testimonis = session()->get('testimonis', []);

    // Tambahkan ID
    $productsWithId = array_map(function ($product, $index) {
        $product['id'] = $index;
        return $product;
    }, $products, array_keys($products));

    // Kirim SEMUA data
    return view('index', [
        'products'   => $productsWithId,
        'categories' => $categories,
        'testimonis' => $testimonis,
    ]);
}

    /*Menampilkan form untuk menambah produk baru.*/
   public function create()
{
    return view('create');
}


    /*Menyimpan produk baru ke dalam array di session.*/
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

    /*Menampilkan form untuk mengedit produk.*/
    public function edit(int $id)
    {
        $products = session()->get('products', []);
        if (!isset($products[$id])) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan!');
        }
        $product = $products[$id];
        $product['id'] = $id; // Sertakan index/id ke view
        $category = $product['category'] ?? null;
        return view('edit', ['product' => $product, 'category' => $category]);
    }

    /*Memperbarui produk di dalam session.*/
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

    /**Menghapus produk dari session.*/
    public function destroy(int $id)
    {
        $products = session()->get('products', []);

        if (!isset($products[$id])) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan!');
        }
        //array_splice untuk menghapus dan mengurutkan ulang index
        array_splice($products, $id, 1);
        session()->put('products', $products);
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }// kode zulfahmi selesai

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
    // Ambil semua data dari session
    $products = session()->get('products', []);
    $categories = session()->get('categories', []);
    $testimonis = session()->get('testimonis', []);

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

    // Kirim SEMUA data ke view (biar gak undefined)
    return view('index', [
        'products'   => $productsWithId,
        'categories' => $categories,
        'testimonis' => $testimonis,
        'keyword'    => $keyword,
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

  public function indexTestimoni()
    {
        $products = session('products', []);
        $categories = session('categories', []);
        $testimonis = session('testimonis', []);
        return view('index', compact('products', 'categories', 'testimonis'));
    }

    public function storeTestimoni(Request $request)
    {
        $testimonis = session('testimonis', []);
        $testimonis[] = [
            'nama' => $request->nama,
            'isi' => $request->isi
        ];

        session(['testimonis' => $testimonis]);
        return redirect()->back()->with('success_testimoni', 'Testimoni berhasil ditambahkan!');
    }

    public function updateTestimoni(Request $request, $id)
    {
        $testimonis = session('testimonis', []);
        if (isset($testimonis[$id])) {
            $testimonis[$id]['isi'] = $request->isi;
            session(['testimonis' => $testimonis]);
            return redirect()->back()->with('success_testimoni', 'Testimoni berhasil diperbarui!');
        }
        return redirect()->back()->with('error', 'Testimoni tidak ditemukan!');
    }

    public function destroyTestimoni($id)
    {
        $testimonis = session('testimonis', []);
        unset($testimonis[$id]);
        session(['testimonis' => array_values($testimonis)]);
        return redirect()->back()->with('success_testimoni', 'Testimoni berhasil dihapus!');
    }

}



