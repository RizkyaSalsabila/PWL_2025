<!DOCTYPE html>
<html>
    <head>
        <title>Data Kategori Produk</title>
    </head>
    <body>
        <h1>Data Kategori Produk</h1>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Kode Kategori</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d->kategori_id }}</td>
                <td>{{ $d->kategori_kode }}</td>
                <td>{{ $d->kategori_nama }}</td>
                <td>{{ $d->deskripsi }}</td>
            </tr>
            @endforeach
        </table>
    </body>
</html>