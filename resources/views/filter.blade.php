<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Produk</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        form { margin-bottom: 20px; }
        label { margin-right: 10px; }
        input { padding: 6px; margin-right: 10px; }
        button { padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        a { text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

    <h1>Filter Produk</h1>

    <form action="{{ route('products.filter') }}" method="GET">
        <label for="category">Kategori:</label>
        <select name="category" id="category">
            <option value="">-- Semua Kategori --</option>
            <option value="Baju" {{ $category == 'Baju' ? 'selected' : '' }}>Baju</option>
            <option value="Celana" {{ $category == 'Celana' ? 'selected' : '' }}>Celana</option>
            <option value="Sepatu" {{ $category == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
            <option value="Jaket" {{ $category == 'Jaket' ? 'selected' : '' }}>Jaket</option>
            <option value="Aksesoris" {{ $category == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
        </select>


        <label for="maxPrice">Harga Maksimum:</label>
        <input type="number" name="maxPrice" id="maxPrice" value="{{ $maxPrice ?? '' }}">

        <button type="submit">Terapkan Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product['nama'] }}</td>
                    <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>
                    <td>{{ $product['category'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada produk yang sesuai filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    <a href="{{ route('products.index') }}">⬅ Kembali ke Daftar Produk</a>

</body>
</html>
