<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // JS3 - P3(seeder)
        $data = [
            [
                'kategori_id' => '1',
                'kategori_kode' => 'KT01',
                'kategori_nama' => 'Aksesoris',
                'deskripsi' => 'Beragam aksesoris pelengkap seperti perhiasan, jam tangan, kacamata, ...',
            ],
            [
                'kategori_id' => '2',
                'kategori_kode' => 'KT02',
                'kategori_nama' => 'Elektronik',
                'deskripsi' => 'Berbagai perangkat elektronik seperti smartphone, laptop, ...',
            ],
            [
                'kategori_id' => '3',
                'kategori_kode' => 'KT03',
                'kategori_nama' => 'Kesehatan',
                'deskripsi' => 'Produk kesehatan seperti vitamin, suplemen, alat medis, ...',
            ],
            [
                'kategori_id' => '4',
                'kategori_kode' => 'KT04',
                'kategori_nama' => 'Perlengkapan Olahraga ',
                'deskripsi' => 'Peralatan dan perlengkapan untuk berbagai jenis olahraga, ...',
            ],
            [
                'kategori_id' => '5',
                'kategori_kode' => 'KT05',
                'kategori_nama' => 'Makanan Minuman',
                'deskripsi' => 'Aneka makanan dan minuman siap saji serta kemasan, ...',
            ],
        ];  

    DB::table('m_kategori')->insert($data);
    }
}