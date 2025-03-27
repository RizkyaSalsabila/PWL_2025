<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds
     */
    public function run(): void {
        $data = [
            [
                'kategori_id' => '1',
                'kode_kategori' => 'KT01',
                'nama_kategori' => 'Aksesoris',
                'deskripsi' => 'Beragam aksesoris pelengkap seperti perhiasan, jam tangan, kacamata, ...',
            ],
            [
                'kategori_id' => '2',
                'kode_kategori' => 'KT02',
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Berbagai perangkat elektronik seperti smartphone, laptop, ...',
            ],
            [
                'kategori_id' => '3',
                'kode_kategori' => 'KT03',
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Produk kesehatan seperti vitamin, suplemen, alat medis, ...',
            ],
            [
                'kategori_id' => '4',
                'kode_kategori' => 'KT04',
                'nama_kategori' => 'Perlengkapan Olahraga ',
                'deskripsi' => 'Peralatan dan perlengkapan untuk berbagai jenis olahraga, ...',
            ],
            [
                'kategori_id' => '5',
                'kode_kategori' => 'KT05',
                'nama_kategori' => 'Makanan Minuman',
                'deskripsi' => 'Aneka makanan dan minuman siap saji serta kemasan, ...',
            ],
        ];  

    DB::table('m_kategori')->insert($data);
    }
}