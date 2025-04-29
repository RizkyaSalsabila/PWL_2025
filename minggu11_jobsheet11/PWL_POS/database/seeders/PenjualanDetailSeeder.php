<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // JS3 - P3(seeder)
        $data = [
            // Transaksi Penjualan 1
            [
                'penjualan_id'  => 1,
                'barang_id'     => 1,
                'harga'         => 500000,
                'jumlah'        => 5,
            ],
            [
                'penjualan_id'  => 1,
                'barang_id'     => 3,
                'harga'         => 150000,
                'jumlah'        => 2,
            ],
            [
                'penjualan_id'  => 1,
                'barang_id'     => 5,
                'harga'         => 300000,
                'jumlah'        => 3,
            ],

            // Transaksi Penjualan 2
            [
                'penjualan_id'  => 2,
                'barang_id'     => 4,
                'harga'         => 100000,
                'jumlah'        => 4,
            ],
            [
                'penjualan_id'  => 2,
                'barang_id'     => 3,
                'harga'         => 55000,
                'jumlah'        => 10,
            ],
            [
                'penjualan_id'  => 2,
                'barang_id'     => 10,
                'harga'         => 70000,
                'jumlah'        => 5,
            ],

            // Transaksi Penjualan 3
            [
                'penjualan_id'  => 3,
                'barang_id'     => 7,
                'harga'         => 100000,
                'jumlah'        => 2,
            ],
            [
                'penjualan_id'  => 3,
                'barang_id'     => 8,
                'harga'         => 80000,
                'jumlah'        => 3,
            ],
            [
                'penjualan_id'  => 3,
                'barang_id'     => 9,
                'harga'         => 95000,
                'jumlah'        => 4,
            ],

            // Transaksi Penjualan 4
            [
                'penjualan_id'  => 4,
                'barang_id'     => 1,
                'harga'         => 100000,
                'jumlah'        => 5,
            ],
            [
                'penjualan_id'  => 4,
                'barang_id'     => 3,
                'harga'         => 150000,
                'jumlah'        => 6,
            ],
            [
                'penjualan_id'  => 4,
                'barang_id'     => 4,
                'harga'         => 175000,
                'jumlah'        => 7,
            ],
            // Transaksi Penjualan 5
            [
                'penjualan_id'  => 5,
                'barang_id'     => 9,
                'harga'         => 80000,
                'jumlah'        => 10,
            ],
            [
                'penjualan_id'  => 5,
                'barang_id'     => 1,
                'harga'         => 95000,
                'jumlah'        => 2,
            ],
            [
                'penjualan_id'  => 5,
                'barang_id'     => 2,
                'harga'         => 120000,
                'jumlah'        => 3,
            ],

            // Transaksi Penjualan 6
            [
                'penjualan_id'  => 6,
                'barang_id'     => 8,
                'harga'         => 250000,
                'jumlah'        => 5,
            ],
            [
                'penjualan_id'  => 6,
                'barang_id'     => 4,
                'harga'         => 700000,
                'jumlah'        => 4,
            ],
            [
                'penjualan_id'  => 6,
                'barang_id'     => 7,
                'harga'         => 50000,
                'jumlah'        => 3,
            ],

            // Transaksi Penjualan 7
            [
                'penjualan_id'  => 7,
                'barang_id'     => 7,
                'harga'         => 100000,
                'jumlah'        => 2,
            ],
            [
                'penjualan_id'  => 7,
                'barang_id'     => 1,
                'harga'         => 170000,
                'jumlah'        => 5,
            ],
            [
                'penjualan_id'  => 7,
                'barang_id'     => 5,
                'harga'         => 180000,
                'jumlah'        => 7,
            ],

            // Transaksi Penjualan 8
            [
                'penjualan_id'  => 8,
                'barang_id'     => 10,
                'harga'         => 45000,
                'jumlah'        => 6,
            ],
            [
                'penjualan_id'  => 8,
                'barang_id'     => 4,
                'harga'         => 90000,
                'jumlah'        => 2,
            ],
            [
                'penjualan_id'  => 8,
                'barang_id'     => 8,
                'harga'         => 110000,
                'jumlah'        => 4,
            ],

            // Transaksi Penjualan 9
            [
                'penjualan_id'  => 9,
                'barang_id'     => 9,
                'harga'         => 125000,
                'jumlah'        => 5,
            ],
            [
                'penjualan_id'  => 9,
                'barang_id'     => 5,
                'harga'         => 180000,
                'jumlah'        => 8,
            ],
            [
                'penjualan_id'  => 9,
                'barang_id'     => 2,
                'harga'         => 100000,
                'jumlah'        => 2,
            ],

            // Transaksi Penjualan 10
            [
                'penjualan_id'  => 10,
                'barang_id'     => 1,
                'harga'         => 450000,
                'jumlah'        => 10,
            ],
            [
                'penjualan_id'  => 10,
                'barang_id'     => 2,
                'harga'         => 500000,
                'jumlah'        => 5,
            ],
            [
                'penjualan_id'  => 10,
                'barang_id'     => 7,
                'harga'         => 750000,
                'jumlah'        => 3,
            ],
        ];

    DB::table('t_penjualan_detail')->insert($data);
    }
}