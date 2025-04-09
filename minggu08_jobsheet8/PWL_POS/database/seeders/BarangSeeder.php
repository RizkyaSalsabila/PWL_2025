<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void { 
        $data = [
            [
                'kategori_id'   => 1,
                'barang_kode'   => 'BR01A',
                'barang_nama'   => 'Jam Tangan',
                'harga_beli'    => 15000,
                'harga_jual'    => 20000,
            ],
            [
                'kategori_id'   => 1,
                'barang_kode'   => 'BR02A',
                'barang_nama'   => 'Kacamata Radiasi',
                'harga_beli'    => 20000,
                'harga_jual'    => 40000,
            ],
            [
                'kategori_id'   => 2,
                'barang_kode'   => 'BR01B',
                'barang_nama'   => 'Tablet',
                'harga_beli'    => 600000,
                'harga_jual'    => 800000,
            ],
            [
                'kategori_id'   => 2,
                'barang_kode'   => 'BR02B',
                'barang_nama'   => 'Smartphone',
                'harga_beli'    => 500000,
                'harga_jual'    => 800000,
            ],
            [
                'kategori_id'   => 3,
                'barang_kode'   => 'BR01C',
                'barang_nama'   => 'Suplemen',
                'harga_beli'    => 20000,
                'harga_jual'    => 22000,
            ],
            [
                'kategori_id'   => 3,
                'barang_kode'   => 'BR02C',
                'barang_nama'   => 'Vitamin C',
                'harga_beli'    => 10000,
                'harga_jual'    => 15000,
            ],
            [
                'kategori_id'   => 4,
                'barang_kode'   => 'BR01D',
                'barang_nama'   => 'Bola Voli',
                'harga_beli'    => 60000,
                'harga_jual'    => 80000,
            ],
            [
                'kategori_id'   => 4,
                'barang_kode'   => 'BR02D',
                'barang_nama'   => 'Bola Basket',
                'harga_beli'    => 40000,
                'harga_jual'    => 50000,
            ],
            [
                'kategori_id'   => 5,
                'barang_kode'   => 'BR01E',
                'barang_nama'   => 'Aqua',
                'harga_beli'    => 3000,
                'harga_jual'    => 5000,
            ],
            [
                'kategori_id'   => 5,
                'barang_kode'   => 'BR02E',
                'barang_nama'   => 'Makaroni Spiral',
                'harga_beli'    => 8000,
                'harga_jual'    => 10000,
            ],
        ];

    DB::table('m_barang')->insert($data);
    }
}