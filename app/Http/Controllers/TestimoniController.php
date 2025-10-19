<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestimoniController extends Controller
{
    public function index()
    {
        $products = session('products', []);
        $categories = session('categories', []);
        $testimonis = session('testimonis', []);
        return view('index', compact('products', 'categories', 'testimonis'));
    }

    public function store(Request $request)
    {
        $testimonis = session('testimonis', []);
        $testimonis[] = [
            'nama' => $request->nama,
            'isi' => $request->isi
        ];

        session(['testimonis' => $testimonis]);
        return redirect()->back()->with('success_testimoni', 'Testimoni berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $testimonis = session('testimonis', []);
        if (isset($testimonis[$id])) {
            $testimonis[$id]['isi'] = $request->isi;
            session(['testimonis' => $testimonis]);
            return redirect()->back()->with('success_testimoni', 'Testimoni berhasil diperbarui!');
        }
        return redirect()->back()->with('error', 'Testimoni tidak ditemukan!');
    }

    public function destroy($id)
    {
        $testimonis = session('testimonis', []);
        unset($testimonis[$id]);
        session(['testimonis' => array_values($testimonis)]);
        return redirect()->back()->with('success_testimoni', 'Testimoni berhasil dihapus!');
    }
}
