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
        // $user = UserModel::findOr(20, ['username', 'nama'], function () {       //penggunaan callback dengan menampilkan 2 kolom pada ID = 20
        //     abort(404);     //jika tidak ada data, maka akan tampil 404/not found
        // });
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.2(1)
        // $user = UserModel::findOrFail(1);       //ambil data pada tabel dengan ID = 1
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.2(2)
        // $user = UserModel::where('username', 'manager9')->firstOrFail();      //ambil data pada tabel dengan username = manager9
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.3(1)
        // $user = UserModel::where('level_id', 2)->count();       //ambil data pada tabel dengan level_id = 2, dan tampilkan jumlahnya
        // dd($user);
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.3(2)
        // $user = UserModel::where('level_id', 2)->count();       //ambil data pada tabel dengan level_id = 2, dan tampilkan jumlahnya
        // dd($user);
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4(1)
        // $user = UserModel::firstOrCreate(       //tampilkan jika ada, jika tidak maka akan dibuatkan
        //     [
        //         'username'  => 'manager',       //dengan username = manager
        //         'nama'      => 'Manager',       //dengan nama = Manager
        //     ],
        // );

        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4(2)
        // $user = UserModel::firstOrCreate(       //tampilkan jika ada, jika tidak maka akan dibuatkan
        //     [
        //         'username' => 'manager22',          //dengan username = manager22
        //         'nama' => 'Manager Dua Dua',        //dengan nama = Manager Dua Dua
        //         'password' => Hash::make('12345'),  //dengan password 
        //         'level_id' => 2                     //dengan level_id = 2
        //     ],
        // );

        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4(3)
        // $user = UserModel::firstOrNew(          //tampilkan jika ada, jika tidak maka akan dibuatkan tapi tidak pada database
        //     [
        //         'username' => 'manager',        //dengan username = manager
        //         'nama'     => 'Manager',        //dengan nama = Manager 
        //     ],
        // );

        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4(4)
        // $user = UserModel::firstOrNew(          //tampilkan jika ada, jika tidak maka akan dibuatkan tapi tidak pada database
        //     [
        //         'username' => 'manager33',                 //dengan username = manager33
        //         'nama'     => 'Manager Tiga Tiga',        //dengan nama = Manager Tiga Tiga
        //         'password' => Hash::make('12345'),        //dengan password
        //         'level_id' => 2                           //dengan level_id = 2
        //     ],
        // );

        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.4(5)
        // $user = UserModel::firstOrNew(          //tampilkan jika ada, jika tidak maka akan dibuatkan tapi tidak pada database
        //     [
        //         'username' => 'manager33',                 //dengan username = manager33
        //         'nama'     => 'Manager Tiga Tiga',        //dengan nama = Manager Tiga Tiga
        //         'password' => Hash::make('12345'),        //dengan password
        //         'level_id' => 2                           //dengan level_id = 2
        //     ],
        // );

        // $user->save();          //melakukan proses penyimpanan ke database
        // return view('user', ['data' => $user]);


        //PRAKTIKUM 2.5(1)
        // $user = UserModel::create([
        //     'username'  => 'manager55',
        //     'nama'      => 'Manager55',
        //     'password'  => Hash::make('12345'),
        //     'level_id'  => 2,
        // ]);
        // $user->username = 'manager56';

        // $user->isDirty();   //true
        // $user->isDirty('username');     //true
        // $user->isDirty('nama');     //false
        // $user->isDirty(['nama', 'username']);     //true

        // $user->isClean();   //false
        // $user->isClean('username');     //false
        // $user->isClean('nama');     //true
        // $user->isClean(['nama', 'username']);     //false

        // $user->save();

        // $user->isDirty();   //false
        // $user->isClean();   //true
        // dd($user->isDirty());


        //PRAKTIKUM 2.5(2)
        // $user = UserModel::create([         //membuat data baru 
        //     'username'  => 'manager_11',     //dengan username 'manager_11'
        //     'nama'      => 'Manager 11',     //dengan nama 'Manager 11'
        //     'password'  => Hash::make('12345'),     //dengan password
        //     'level_id'  => 2,               //dengan level_id '2' 
        // ]);
        // $user->username = 'manager_12';      //mengubah username menjadi 'manager_12'

        // $user->save();          //disimpan dalam database

        // $user->wasChanged();   //true
        // $user->wasChanged('username');     //true
        // $user->wasChanged(['username', 'level_id']);    //true
        // $user->wasChanged('nama');     //false
        // dd($user->wasChanged(['nama', 'username']));     //true


        //PRAKTIKUM 2.6(1)
        $user = UserModel::all();           //ambil semua data dari tabel 'm_user'
        return view('user', ['data' => $user]);     //mengirimkan data ke tampilan 'user.blade.php'

    } 

    //PRAKTIKUM 2.6(2) - SOAL 6
    public function tambah() {
        return view('user_tambah');
    }

    //PRAKTIKUM 2.6(3) - SOAL 9
    public function tambah_simpan(Request $request) {       //untuk menerima data dari form inputan
        UserModel::create([             //menyimpan data ke database
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');       //mengembalikan hasilnya ke tampilan view 'user'
    }

    //PRAKTIKUM 2.6(4) - SOAL 13
    public function ubah($id) {         //ambil data sesuai ID yang dipilih
        $user = UserModel::find($id);   //mencari data yang sesuai dengan ID tersebut
        return view('user_ubah', ['data' => $user]);        //mengirimkan data ke tampilan 'user_ubah.blade.php'
    }

    //PRAKTIKUM 2.6(5) - SOAL 16
    public function ubah_simpan($id, Request $request) {        //untuk menerima data dari form inputan 
                                                                //dan ambil data sesuai ID yang dipilih
        $user = UserModel::find($id);           //mencari data yang sesuai dengan ID tersebut

        $user->username = $request->username;
        $user->nama     = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;
        
        $user->save();      //untuk menyimpan perubahan ke database

        return redirect('/user');       //mengembalikan hasilnya ke tampilan view 'user'
    }
}