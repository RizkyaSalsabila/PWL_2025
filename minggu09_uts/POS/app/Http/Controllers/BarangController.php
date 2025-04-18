<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_barang(kategori_id, barang_kode, barang_nama, harga_beli, harga_jual, created_at) values(?, ?, ?, ?, ?, ?)', [5, 'BR03E', 'Makaroni Pedas', 10000, 12000, now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update m_barang set harga_jual = ? where barang_kode = ?', [15000, 'BR03E']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_barang where barang_kode = ?', ['BR03E']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        $data = DB::select('select * from m_barang'); // Menampilkan semua data dari tabel 'm_barang'
        return view('barang', ['data' => $data]);
    }
}