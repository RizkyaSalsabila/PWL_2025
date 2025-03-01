<!DOCTYPE html>
<html>
<head>
    <title>Add Item | Rizkya Salsabila</title>
</head>
<body>
    <h1>Add Item</h1>       <!--penamaan judul halaman di tab browser -->
    <form action="{{ route('items.store') }}" method="POST"> <!-- Form untuk menambahkan item baru, kemudian mengarah ke route 'items.store' dengan metode POST --> 
        @csrf        <!-- Token keamanan untuk mencegah serangan CSRF -->
        <!-- label dan input untuk nama item -->
        <label for="name">Name:</label>     <!-- Label untuk input nama -->
        <input type="text" name="name" required><br><br>    <!-- Input teks untuk nama, wajib diisi -->

        <!-- label dan input untuk deskripsi item -->
        <label for="description">Description:</label>   <!-- Label untuk input deskripsi -->
        <textarea name="description" required></textarea><br><br>

        <!-- label dan input untuk stok item -->
        <label for="stock">Stock:</label>   <!-- Label untuk input stok -->
        <input type="text" name="stock" required><br><br>   <!-- Input teks untuk stok, wajib diisi -->

        <!-- label dan input untuk harga item -->
        <label for="price">Price:</label>   <!-- Label untuk input harga -->
        <input type="text" name="price" required><br><br><br>   <!-- Input teks untuk harga, wajib diisi -->

        <!-- tombol submit untuk mengirimkan form -->
        <button type="submit">Add Item</button>
    </form>

    <!-- link untuk kembali ke daftar item -->
    <a href="{{ route('items.index') }}">Back to list</a>
</body>
</html>