<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into t_penjualan_detail(penjualan_id, barang_id, harga, jumlah, created_at) values(?, ?, ?, ?, ?)', [9, 10, 180000, 8, now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update t_penjualan_detail set jumlah_barang = ? where detail_id = ?', [5, 9]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from t_penjualan_detail where detail_id = ?', [9]);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from t_penjualan_detail'); // Menampilkan semua data dari tabel 't_penjualan_detail'
        // return view('penjualan_detail', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 't_penjualan_detail'
        $data = [
            'penjualan_id' => 1,
            'barang_id' => 3,
            'harga' => 25000,
            'jumlah' => 2
        ];

        PenjualanDetailModel::create($data);

        //mencoba akses model PenjualanDetailModel
        $penjualan_detail = PenjualanDetailModel::all();       //ambil semua data dari tabel 't_penjualan_detail'
        return view('penjualan_detail', ['data' => $penjualan_detail]);
    }
}