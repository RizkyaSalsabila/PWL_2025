<!DOCTYPE html>
<html>
    <head>
        <title>Profile POS | RizkyaSalsabila</title>
        <style>
            .btn-kembali {
                background-color: #d633ff; /* Warna Oranye */
                color: white;
                padding: 12px 24px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                transition: background 0.3s;
            }

            .btn-kembali:hover {
                background-color: #ff33ee; /* Warna merah saat hover */
            }
        </style>
    </head>
    <body>
        <h1>Nama : {{ $name }}</h1>
        <h1>ID : {{ $id }}</h1>
    </body>

    <button class="btn-kembali" onclick="window.location.href='../../..'">Kembali ke Menu Utama</button>
</html>