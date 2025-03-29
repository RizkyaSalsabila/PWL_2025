<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id'           => 3,
                'pembeli'           => 'Adrian Setiawan',
                'penjualan_kode'    => 'PNJ01',
                'penjualan_tanggal' => '2024-01-15 08:30:20',
            ],
            [
                'user_id'           => 1,
                'pembeli'           => 'Jihan Maharani',
                'penjualan_kode'    => 'PNJ02',
                'penjualan_tanggal' => '2024-02-28 14:45:10',
            ],
            [
                'user_id'           => 2,
                'pembeli'           => 'Hana Oktaviani',
                'penjualan_kode'    => 'PNJ03',
                'penjualan_tanggal' => '2024-03-10 19:20:35',
            ],
            [
                'user_id'           => 2, 
                'pembeli'           => 'Indra Yudha',
                'penjualan_kode'    => 'PNJ04',
                'penjualan_tanggal' => '2024-04-22 07:05:50',
            ],
            [
                'user_id'           => 1, 
                'pembeli'           => 'Galih Permana',
                'penjualan_kode'    => 'PNJ05',
                'penjualan_tanggal' => '2024-05-17 23:10:15',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Eka Widyaningsih',
                'penjualan_kode'    => 'PNJ06',
                'penjualan_tanggal' => '2024-06-30 12:55:40',
            ],
            [
                'user_id'           => 2,
                'pembeli'           => 'Cahya Ramadhan',
                'penjualan_kode'    => 'PNJ07',
                'penjualan_tanggal' => '2024-07-08 16:30:05',
            ],
            [
                'user_id'           => 1,
                'pembeli'           => 'Dimas Arief',
                'penjualan_kode'    => 'PNJ08',
                'penjualan_tanggal' => '2024-08-25 20:15:55',
            ],
            [
                'user_id'           => 2,
                'pembeli'           => 'Bella Cahyani',
                'penjualan_kode'    => 'PNJ09',
                'penjualan_tanggal' => '2024-09-14 05:45:30',
            ],
            [
                'user_id'           => 3,
                'pembeli'           => 'Irfan Rizaldi',
                'penjualan_kode'    => 'PNJ10',
                'penjualan_tanggal' => '2024-10-29 10:00:00',
            ],
        ];

    DB::table('t_penjualan')->insert($data);
    }
}