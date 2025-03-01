<!DOCTYPE html>
<html>
<head>
    <title>Edit Item | Rizkya Salsabila</title>      <!--penamaan judul halaman di tab browser -->
</head>
<body>
    <h1>Edit Item</h1>      <!-- heading utama halaman -->

    <!-- form untuk mengedit item, mengarah ke route 'items.update' dengan parameter $item -->
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf   <!-- token CSRF untuk keamanan terhadap serangan CSRF -->
        @method('PUT')      <!-- menggunakan metode PUT untuk mengupdate data -->
        
        <!-- label dan input untuk nama item -->
        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $item->name }}" required><br><br>  <!-- input teks dengan nilai default dari $item->name -->

        <!-- label dan input untuk deskripsi item -->
        <label for="description">Description:</label>
        <textarea name="description" required>{{ $item->description }}</textarea><br><br>   <!-- textarea dengan nilai default dari $item->description -->

        <!-- label dan input untuk stok item -->
        <label for="stock">Stock:</label>
        <input type="text" name="stock" value="{{ $item->stock }}" required><br><br>    <!-- input teks dengan nilai default dari $item->stock -->

        <!-- label dan input untuk harga item -->
        <label for="price">Price:</label>
        <input type="text" name="price" value="{{ $item->price }}" required><br><br><br>    <!-- input teks dengan nilai default dari $item->price -->

        <!-- tombol submit untuk mengupdate item -->
        <button type="submit">Update Item</button>
    </form>

     <!-- link untuk kembali ke daftar item -->
    <a href="{{ route('items.index') }}">Back to list</a>
</body>
</html>