<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // JS3 - P3(seeder)
        $data = [
            [
                'supplier_id'   => 1,
                'supplier_kode' => 'SUP001',
                'supplier_nama' => 'PT. Sumber Jaya',
                'supplier_alamat' => 'Jl. Merdeka No. 123, Surabaya',
                'supplier_no_hp'  => '081234567890'
            ],
            [
                'supplier_id'   => 2,
                'supplier_kode' => 'SUP002',
                'supplier_nama' => 'CV. Makmur Sentosa',
                'supplier_alamat' => 'Jl. Raya Malang No. 45, Malang',
                'supplier_no_hp'  => '082112223344'
            ],
            [
                'supplier_id'   => 3,
                'supplier_kode' => 'SUP003',
                'supplier_nama' => 'UD. Tani Subur',
                'supplier_alamat' => 'Jl. Pertanian No. 7, Pasuruan',
                'supplier_no_hp'  => '085566778899'
            ],
        ];
        
        DB::table('m_supplier')->insert($data);
    }
}