<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // public function profile ($id, $name) {
    //     return view('profile')
    //     ->with('id', $id)
    //     ->with('name', $name);
    // }

    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_user(level_id, username, nama, password, created_at) values(?, ?, ?, ?, ?)', [3, 'kasirPertama', 'Kasir Pertama', Hash::make('123456'), now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update m_user set username = ? where username = ?', ['kasir1', 'kasirPertama']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_user where username = ?', ['kasir1']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        $data = DB::select('select * from m_user'); // Menampilkan semua data dari tabel 'm_user'
        return view('user', ['data' => $data]);
    }         
}