<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']); 
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']); // Menghapus data dengan kode = 'CUS'
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from m_level'); // Menampilkan semua data dari tabel 'm_level'
        // return view('level', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_level'
        $data = [
            'level_kode' => 'SUP',
            'level_nama' => 'Supervisor'
        ];

        LevelModel::create($data);

        //mencoba akses model BarangModel
        $level = LevelModel::all();       //ambil semua data dari tabel 'm_level'
        return view('level', ['data' => $level]);
    }
}