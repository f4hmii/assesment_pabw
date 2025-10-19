<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-right: 5px;
            border: none;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-create {
            background-color: #007bff;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .action-cell form {
            display: inline-block;
            margin: 0;
        }

        .alert {
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>

<body>
    <form action="{{ route('products.search') }}" method="GET" class="mb-4 flex gap-2">
        <input
            type="text"
            name="keyword"
            value="{{ request('keyword') }}"
            placeholder="Cari produk..."
            class="border px-3 py-2 rounded w-full">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
    </form>

    @if (!empty($keyword))
    <p class="mb-4 text-gray-600">Hasil pencarian untuk: <strong>"{{ $keyword }}"</strong></p>
    @endif

    <h1>Daftar Produk MOVR</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-create">Tambah Produk Baru</a>
    
    <a href="{{ route('products.filter') }}" class="btn btn-filter">Filter Produk</a>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product['nama'] }}</td>
                <td>Rp {{ number_format($product['harga'], 0, ',', '.') }}</td>

                <td class="action-cell">
                    <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('products.destroy', $product['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Belum ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <hr style="margin-top: 50px;">

    <h2>Testimoni Pelanggan</h2>

    {{-- Pesan sukses (hanya satu kali) --}}
    @if(session('success_testimoni'))
    <div class="alert alert-success">
        {{ session('success_testimoni') }}
    </div>
    @endif

    <!-- Form Tambah Testimoni -->
    <form action="{{ route('testimoni.store') }}" method="POST" style="display: flex; gap: 10px; margin-bottom: 20px;">
        @csrf
        <input type="text" name="nama" placeholder="Nama pelanggan..." required
            style="padding: 8px; width: 200px;">
        <input type="text" name="isi" placeholder="Tulis testimoni..." required
            style="padding: 8px; flex: 1;">
        <button type="submit" class="btn btn-create">Tambah Testimoni</button>
    </form>

    <!-- Tabel Testimoni -->
    <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse;">
        <thead style="background-color: #f8f9fa;">
            <tr>
                <th style="width: 20%;">Nama</th>
                <th>Isi Testimoni</th>
                <th style="width: 200px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($testimonis as $index => $t)
            <tr>
                <td>{{ $t['nama'] }}</td>
                <td>
                    <!-- Form Update hanya untuk kolom isi -->
                    <form action="{{ route('testimoni.update', $index) }}" method="POST" style="display: flex; gap: 8px;">
                        @csrf
                        @method('PUT')
                        <input type="text" name="isi" value="{{ $t['isi'] }}" style="flex: 1; padding: 6px;">
                </td>
                <td style="text-align: center;">
                    <button type="submit" class="btn btn-edit" style="margin-right: 5px;">Update</button>
                    </form>

                    <form action="{{ route('testimoni.destroy', $index) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Belum ada testimoni.</td>
            </tr>
            @endforelse
        </tbody>
    </table>



</body>

</html>