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
        <h1><i>Beauty and Health</i> Category</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga (Rp) </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Facial Wash</td>
                    <td>60.000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Body Lotion</td>
                    <td>85.000</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Serum</td>
                    <td>60.000</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Essential Oil</td>
                    <td>130.000</td>
                </tr>
            </tbody>
        </table>

        <button class="btn-kembali" onclick="window.location.href='../'">Kembali</button>
    </body>
</html>