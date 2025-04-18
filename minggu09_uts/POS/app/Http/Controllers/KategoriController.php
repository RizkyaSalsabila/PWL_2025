<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_kategori(kategori_kode, kategori_nama, deskripsi, created_at) values(?, ?, ?, ?)', ['KT06', 'Perawatan', 'Produk untuk perawatan tubuh dan kecantikan', now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update m_kategori set kategori_nama = ? where kategori_kode = ?', ['Perawatan dan Kecantikan', 'KT06']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_kategori where kategori_kode = ?', ['KT06']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        $data = DB::select('select * from m_kategori'); // Menampilkan semua data dari tabel 'm_kategori'
        return view('kategori', ['data' => $data]);
    }
}