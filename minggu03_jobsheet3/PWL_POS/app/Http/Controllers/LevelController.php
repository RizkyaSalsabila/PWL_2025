<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        //KODE AWAL
        // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        // return 'Insert data baru berhasil';

        //KODE BARU
        $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']); 
        return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';
    }
}