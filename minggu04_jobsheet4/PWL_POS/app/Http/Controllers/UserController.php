<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        //tambah data user dengan Eloquent
        $data =[
            'nama' => 'Pelanggan Pertama'
        ];

        UserModel::where('username', 'customer-1')->update($data);  //update data user

        //mencoba akses model UserModel
        $user = UserModel::all();       //ambil semua data dari tabel 'm_user'
        return view('user', ['data' => $user]);


        //Menambahkan data baru menggunakan Eloquent
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'), // class untuk mengenkripsi/hash password
        //     'level_id' => 5
        // ];

        // UserModel::insert($data); //menambahkan data ke tabel 'm_user'
    }
}
