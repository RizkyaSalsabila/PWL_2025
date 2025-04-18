<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, penjualan_tanggal, created_at) values(?, ?, ?, ?, ?)', [3, 'Alfiyatur Rohmah', 'PNJ11', now(), now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Alfiyatur Nur Rohmah', 'PNJ11']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['PNJ11']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from t_penjualan'); // Menampilkan semua data dari tabel 't_penjualan'
        // return view('penjualan', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 't_penjualan'
        $data = [
            'user_id' => 2,
            'pembeli' => 'Budi Santoso',
            'penjualan_kode' => 'PNJ11',
            'penjualan_tanggal' => now()
        ];

        PenjualanModel::create($data);

        //mencoba akses model BarangModel
        $penjualan = PenjualanModel::all();       //ambil semua data dari tabel 't_penjualan'
        return view('penjualan', ['data' => $penjualan]);
    }  
}