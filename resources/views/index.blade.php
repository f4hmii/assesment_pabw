<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .alert-success { padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px;}
    </style>
</head>
<body>

    <h1>Daftar Produk (Disimpan di Session)</h1>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('products.create') }}" class="btn">Tambah Produk Baru</a>
    <br><br>

    <table>
        <thead>
            <tr>
                {{-- Kolom ID dihapus --}}
                <th>Nama Produk</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    {{-- Kolom ID dihapus --}}
                    <td>{{ $product['nama'] }}</td>
                    <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    {{-- Colspan diubah dari 3 menjadi 2 --}}
                    <td colspan="2">Belum ada produk.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>