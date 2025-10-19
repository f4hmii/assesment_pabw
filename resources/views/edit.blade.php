<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 15px; background-color: #ffc107; color: black; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; }
        .alert-danger { padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;}
        .back-link { margin-top: 20px; display: inline-block; }
    </style>
</head>
<body>
    <h1>Form Edit Produk</h1>

    @if ($errors->any())
        <div class="alert-danger">
            <strong>Whoops! Ada beberapa masalah dengan input Anda.</strong><br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Produk:</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $product['nama']) }}">
        </div>
        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="{{ old('harga', $product['harga']) }}">
        </div>

        <!-- {{-- kode fairuz: input kategori --}} -->
         <label for="category">Kategori:</label>
        <select name="category" id="category">
            <option value="">-- Semua Kategori --</option>
           @php $cur = old('category', $product['category'] ?? '') @endphp

        <select name="category" id="category">
            <option value="">-- Pilih Kategori --</option>
            <option value="Baju" {{ $cur == 'Baju' ? 'selected' : '' }}>Baju</option>
            <option value="Celana" {{ $cur == 'Celana' ? 'selected' : '' }}>Celana</option>
            <option value="Sepatu" {{ $cur == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
            <option value="Jaket" {{ $cur == 'Jaket' ? 'selected' : '' }}>Jaket</option>
            <option value="Aksesoris" {{ $cur == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
        </select>
        <button type="submit" class="btn">Update Produk</button>
    </form>

    <a href="{{ route('products.index') }}" class="back-link">Kembali ke Daftar Produk</a>

</body>
</html>
