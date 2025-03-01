<!DOCTYPE html>
<html>
<head>
    <title>Item List | Rizkya Salsabila</title>     <!--penamaan judul halaman di tab browser -->
</head>
<body>
    <h1>Items</h1>       <!-- heading utama halaman -->
    <!-- menampilkan pesan sukses -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <!-- link untuk menambahkan item baru -->
    <a href="{{ route('items.create') }}">Add Item</a>
    <ul>
        <!-- loop melalui semua item dan menampilkannya dalam daftar -->
        @foreach ($items as $item)
            <li>
                 <!-- menampilkan nama item -->
                {{ $item->name }} -
                <!-- link untuk mengedit item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>
                <!-- formulir untuk menghapus item -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;">
                    @csrf   <!-- token CSRF untuk keamanan -->
                    @method('DELETE')   <!-- menggunakan metode DELETE untuk menghapus item -->
                    <button type="submit">Delete</button>   <!-- tombol untuk menghapus item -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>