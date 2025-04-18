<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_supplier(supplier_kode, supplier_nama, supplier_alamat, supplier_no_hp, created_at) values(?, ?, ?, ?, ?)', ['SUP004', 'CV. Berkah Abadi', 'Jl. Gatot Subroto No. 21, Sidoarjo',  '081322334455', now()]);
        // return 'Insert data baru berhasil';

        // // KODE KEDUA
        // $row = DB::update('update m_supplier set supplier_nama = ? where supplier_kode = ?', ['PT. Maju Lancar', 'SUP004']); 
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_supplier where supplier_kode = ?', ['SUP004']); // Menghapus data dengan kode = 'SUP004'
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from m_supplier'); // Menampilkan semua data dari tabel 'm_supplier'
        // return view('supplier', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_supplier'
        $data = [
            'supplier_kode'   => 'SUP004',
            'supplier_nama'   => 'PT. Sumber Rezeki',
            'supplier_alamat' => 'Jl. Industri No. 12, Malang',
            'supplier_no_hp'  => '081234567890'
        ];

        SupplierModel::create($data);

        //mencoba akses model SupplierModel
        $supplier = SupplierModel::all();       //ambil semua data dari tabel 'm_supplier'
        return view('supplier', ['data' => $supplier]);
    }   
}