<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
            color: #333;
        }

        .text-center {
            text-align: center;
            margin-bottom: 10px;
        }

        .text-right {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table td {
            padding: 4px 0;
        }

        .line {
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }

        .total {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
        }

        .thank-you {
            margin-top: 15px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <strong style="font-size: 16px;">LapakKu</strong><br>
        Jl. Kembang Turi No.45, Malang<br>
        <div class="line"></div>
    </div>

    <p>
        <strong>Kode    :</strong> {{ $penjualan->penjualan_kode }}<br>
        <strong>Kasir   :</strong> {{ $penjualan->user->nama }}<br>
        <strong>Tanggal :</strong> {{ $penjualan->penjualan_tanggal }}<br><br>
        <strong>Pembeli :</strong> {{ $penjualan->pembeli }}<
    </p>

    <div class="line"></div>

    <table>
        @php $total = 0; @endphp
        @foreach ($penjualan->penjualan_detail as $d)
            @php
                $subtotal = $d->harga * $d->jumlah;
                $total += $subtotal;
            @endphp
            <tr>
                <td colspan="2"><strong>{{ $d->barang->barang_nama }}</strong></td>
            </tr>
            <tr>
                <td>{{ $d->jumlah }} x Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="line"></div>

    <p class="text-right total">Total: Rp {{ number_format($total, 0, ',', '.') }}</p>

    <div class="text-center thank-you">
        <div class="line"></div>
        *Terima kasih telah berbelanja*<br>
        <div class="line"></div>
    </div>
</body>

</html>