<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        //tambah data user dengan Eloquent
        // $data =[
        //     'nama' => 'Pelanggan Pertama'
        // ];

        // UserModel::where('username', 'customer-1')->update($data);  //update data user

        //Menambahkan data baru menggunakan Eloquent
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'), // class untuk mengenkripsi/hash password
        //     'level_id' => 5
        // ];

        // UserModel::insert($data); //menambahkan data ke tabel 'm_user'
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_user'
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];

        //menambahkan data baru lagi ke 'm_user'
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];

        // UserModel::create($data);

        // //mencoba akses model UserModel
        // $user = UserModel::all();       //ambil semua data dari tabel 'm_user'
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1(1)
        // $user = UserModel::find(1);     //ambil data pada tabel user dengan ID 1
        // return view('user', ['data' => $user]);

        // //PRAKTIKUM 2.1(2)
        // $user = UserModel::where('level_id', 1)->first();       //ambil data pada tabel user berdasarkan kolom 'level_id' pada baris pertama
        // return view('user', ['data' => $user]);

        // //PRAKTIKUM 2.1(3)
        // $user = UserModel::firstWhere('level_id', 1);       //fungsinya masih sama dengan langkah sebelumnya, namun kode menjadi lebih singkat
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1(4)
        // $user = UserModel::findOr(1, ['username', 'nama'], function () {    //penggunaan callback dengan menampilkan 2 kolom pada ID = 1
        //     abort(404);     //jika tidak ada data, maka akan tampil 404/not found
        // }); 
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1(5)
        $user = UserModel::findOr(20, ['username', 'nama'], function () {       //penggunaan callback dengan menampilkan 2 kolom pada ID = 20
            abort(404);     //jika tidak ada data, maka akan tampil 404/not found
        });
        return view('user', ['data' => $user]);
    } 
}