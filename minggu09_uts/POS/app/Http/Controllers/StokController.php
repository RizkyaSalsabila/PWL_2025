<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into t_stok(barang_id, user_id, supplier_id, stok_tanggal, stok_jumlah, created_at) values(?, ?, ?, ?, ?, ?)', [10, 1, 1, now(), 100, now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update t_stok set stok_jumlah = ? where stok_id = ?', [20, 10]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from t_stok where stok_id = ?', [10]);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        $data = DB::select('select * from t_stok'); // Menampilkan semua data dari tabel 't_stok'
        return view('stok', ['data' => $data]);
    }
}