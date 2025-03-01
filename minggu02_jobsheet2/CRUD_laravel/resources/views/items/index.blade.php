<!DOCTYPE html>
<html>
<head>
    <title>Item List | Rizkya Salsabila</title>
</head>
<body>
    <h1>Items</h1>
    <!-- menampilkan pesan sukses -->
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <!-- membuat tombol tambah item menggunakan route('items.create') -->
    <a href="{{ route('items.create') }}">Add Item</a>

    <!-- menampilkan daftar item dalam bentuk list -->
    <ul>
        @foreach ($items as $item)  <!-- melakukan perulangan untuk menampilkan daftar item -->
            <li>
                {{ $item->name }} -      <!-- menampilkan nama item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>     <!-- link untuk mengedit item -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display: inline;">      <!-- form untuk menghapus item -->
                    @csrf   <!-- token keamanan untuk mencegah serangan CSRF -->
                    @method('DELETE')   <!-- mengubah method menjadi DELETE -->
                    <button type="submit">Delete</button>   <!-- tombol untuk menghapus item -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>