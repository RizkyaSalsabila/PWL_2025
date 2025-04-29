<!DOCTYPE html>
<html>
    <head>
        <title>Category POS | RizkyaSalsabila</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-size: 18px;
                text-align: left;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f4f4f4;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
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
        <h1><i>Home Care</i> Category</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Perawatan</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Pijat Relaksasi</td>
                    <td>Pijat untuk mengurangi stres dan nyeri otot</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Perawatan Kulit</td>
                    <td>Masker wajah, pelembab, dan perawatan jerawat</td>
                </tr>
            </tbody>
        </table>

        <button class="btn-kembali" onclick="window.location.href='../'">Kembali</button>
    </body>
</html>