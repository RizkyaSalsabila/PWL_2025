<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    // public function index()
    // {
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
    //     $user = UserModel::all();           //ambil semua data dari tabel 'm_user'
    //     return view('user', ['data' => $user]);     //mengirimkan data ke tampilan 'user.blade.php'

    // } 

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

    //PRAKTIKUM 2.6(6) - SOAL 19
    public function hapus($id) {        //hapus data sesuai ID yang dipilih
        $user = UserModel::find($id);   //mencari data yang sesuai dengan ID tersebut
        $user->delete();        //untuk menghapus dari database

        return redirect('/user');       //mengembalikan hasilnya ke tampilan view 'user'
    }

    //PRAKTIKUM 2.7(1) - SOAL 2
    // public function index() {       //fungsi untuk ambil semua data dari tabel user dengan relasinya level
    //     $user = UserModel::with('level')->get();        //mengambil data dari tabel users termasuk relasinya berdasarkan level_id di users
    //     dd($user);      //tampilkan hasilnya menggunakan 'die dump'
    // }

    //PRAKTIKUM 2.7(2) - SOAL 4
    // public function index() {       //fungsi untuk ambil semua data dari tabel user dengan relasinya level
    //     $user = UserModel::with('level')->get();        //mengambil data dari tabel users termasuk relasinya berdasarkan level_id di users
    //     return view('user', ['data' => $user]);         //mengirimkan data ke tampilan 'user.blade.php'
    // }

    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    // JS5 - P3(4)
    //menampilkan halaman awal user 
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list'  => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';   //set menu yang sedang aktif

        // JS5 - P4(1)
        $level = LevelModel::all();     //ambil data level untuk filter level

        return view(
            'user.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                'level' => $level
                ]
        );
    }


    // JS5 - P3(7)
    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                        ->with('level');

        // JS5 - P4(5)
        // //filter data user berdasarkan level_id
        // if ($request->level_id) {
        //     $users->where('level_id', $request->level_id);
        // }

        // -- JS8 - Tugas(m_user)--
        $level_id = $request->input('filter_level'); 
        if(!empty($level_id)) {             
            $users->where('level_id', $level_id);       
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($user) {
                // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // $btn .= ' <a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // $btn .= ' <form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                //     . csrf_field()
                //     . method_field('DELETE')
                //     . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                //     . '</form>';

                // JS6 - P2(2)
                $btn  = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // JS5 - P3(9)
    //menampilkan halaman form tambah user
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah User Baru'
        ];

        $level = LevelModel::all();     //ambil data level untuk ditampilkan di form
        $activeMenu = 'user';           //set menu yang sedang aktif

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // JS5 - P3(11)  
    //menyimpan data user baru
    public function store(Request $request) {
        $request->validate([
            //username harus diisi, berupa string, minim 3 karakter, bernilai unik di tabel m_user kolom username
            'username'  => 'required|string|min:3|unique:m_user,username',
            'nama'      => 'required|string|max:100',   //nama harus diisi, berupa string, maks 100 karakter
            'password'  => 'required|string|min:5',     //password harus diisi, berupa string, min 5 karakter
            'level_id'  => 'required|integer',          //level_id harus diisi, berupa integer
        ]);

        UserModel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => bcrypt($request->password),      //password dienkripsi terlebih dahulu sebelum disimpan
            'level_id'  => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data User berhasil disimpan');
    }  

    // JS5 - P3(14)  
    //menampilkan detail user
    public function show(string $id) {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list'  => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';       //set menu yang sedang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // JS5 - P3(18) 
    //menampilkan halaman form edit user
    public function edit(string $id) {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list'  => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user';       //set menu yang sedang aktif

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //menyimpan perubahan data user 
    public function update(Request $request, string $id) {
        $request->validate([
            //username harus diisi, berupa string, minim 3 karakter, bernilai unik di tabel m_user kolom username
            //kecuali untuk user dengan id yang sedang diedit
            'username'  => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',
            'nama'      => 'required|string|max:100',   //nama harus diisi, berupa string, maks 100 karakter
            'password'  => 'nullable|string|min:5',     //password bisa diisi(min 5 karakter) dan bisa tidak diis 
            'level_id'  => 'required|integer',          //level_id harus diisi, berupa integer(angka)
        ]);

        UserModel::find($id)->update([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,      //password dienkripsi terlebih dahulu sebelum disimpan
            'level_id'  => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data User berhasil diubah');
    } 

    // JS5 - P3(22)
    //menghapus data user
    public function destroy(string $id) {
        $check = UserModel::find($id);
        if (!$check) {  //untuk mengecek apakah data user denan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data User tidak ditemukan');
        }

        try {
            UserModel::destroy($id);    //Hapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            //jika terjadi error ketika menghapus data,
            //redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // -----------------------------------------------------------------------------------------


    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - P1(7)
    public function create_ajax() {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')->with('level', $level);
    }

    // JS6 - P1(9)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                // 'level_id' => 'required|integer',
                // 'username' => 'required|string|min:3|unique:m_user,username',
                // 'nama'     => 'required|string|max:100',
                // 'password' => 'required|min:6'

                // -- JS8 - Tugas(m_user) --
                'level_id' => ['required', 'integer'],
                'username' => ['required', 'string', 'min:3', 'unique:m_user,username'],
                'nama'     => ['required', 'string', 'max:100'],
                'password' => ['required', 'min:6'],
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            // UserModel::create($request->all()); PERBAIKAN KODE ADA DI BAWAH

            $dataBaru = $request->all();
            $dataBaru['password'] = Hash::make($request->password);

            UserModel::create($dataBaru);

            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
    
        redirect('/');
    }    

    // JS6 - P2(4) 
    //menampilkan halaman form edit user ajax
    public function edit_ajax(string $id) {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // JS6 - P2(6) 
    public function update_ajax(Request $request, $id)
     {
         // cek apakah request dari ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                //  'level_id' => 'required|integer',
                //  'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                //  'nama'     => 'required|max:100',
                //  'password' => 'nullable|min:6|max:20'

                // -- JS8 - Tugas(m_user) --
                'level_id' => ['required', 'integer'],
                'username' => ['required', 'string', 'min:3', 'unique:m_user,username,' . $id . ',user_id'],
                'nama'     => ['required', 'string', 'max:100'],
                'password' => ['required', 'min:6'],
             ];

             $validator = Validator::make($request->all(), $rules);

             if ($validator->fails()) {
                 return response()->json([
                     'status' => false, // respon json, true: berhasil, false: gagal
                     'message' => 'Validasi gagal.',
                     'msgField' => $validator->errors() // menunjukkan field mana yang error
                 ]);
             }

             $check = UserModel::find($id);
             if ($check) {
                 if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                     $request->request->remove('password');
                 }

                 $check->update($request->all());
                 return response()->json([
                     'status' => true,
                     'message' => 'Data berhasil diupdate'
                 ]);
             } else {
                 return response()->json([
                     'status' => false,
                     'message' => 'Data tidak ditemukan'
                 ]);
             }
         }
         return redirect('/');
     }

    //JS6 - P3(3)
     public function confirm_ajax(string $id) {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
     }

    // JS6 - P3(5)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
        
    // -- ----------------------------------------------------------------------------------------- --
    // -- ------------------------------------- *jobsheet 08* ------------------------------------- --
    // -- JS8 - Tugas(m_user) --
    public function import() {
        return view('user.import');
    }

    // -- JS8 - Tugas(m_user) --
    public function import_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                //validasi file harus xls atau xlsx, max 1MB
                'file_user' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgFiled'  => $validator->errors()
                ]);
            }

            $file = $request->file('file_user');      //ambil file dari request

            $reader = IOFactory::createReader('Xlsx');  //load reader file excel
            $reader->setReadDataOnly(true);             //hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath());     //load file excel
            $sheet = $spreadsheet->getActiveSheet();                //ambil sheet yang aktif

            $data = $sheet->toArray(null, false, true, true);       //ambil data excel

            $insert = [];
            if (count($data) > 1) {     //jika data lebih dari satu baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {   //baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'level_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'password' => bcrypt($value['D']),
                            'created_at' => now(),
                        ];
                    }
                }

                //insert data ke database, jika data sudah ada maka diabaikan
                if (count($insert) > 0) {
                    UserModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            } 
        }

        return redirect('/');
    } 

    // -- JS8 - Tugas2(m_user) --
    public function export_excel() {
        //ambil data user beserta level yang akan di export
        $user = UserModel::select('level_id', 'username', 'nama')
                    ->orderBy('level_id')        // urutkan berdasarkan level
                    ->with('level')              // ambil relasi level
                    ->get();

        // load library excel atau PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif untuk digunakan

        // set header kolom di baris pertama
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama User');
        $sheet->setCellValue('D1', 'Level');

        // buat teks di header menjadi bold
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);   // bold header

        $no = 1;         // nomor data dimulai dari 1
        $baris = 2;      // baris data dimulai dari baris ke 2
        // loop untuk menuliskan data ke dalam sheet
        foreach ($user as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);    // No
            $sheet->setCellValue('B' . $baris, $value->username);    // Username
            $sheet->setCellValue('C' . $baris, $value->nama);    // Nama User
            $sheet->setCellValue('D' . $baris, $value->level->level_nama); // ambil nama level dari relasi
            $baris++;   // pindah ke baris berikutnya
            $no++;      // tambah nomor urut
        }

        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        // set nama sheet
        $sheet->setTitle('Data User'); // set title sheet

        // buat writer untuk menyimpan spreadsheet ke format Excel (.xlsx)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';

        // set header HTTP agar browser tahu ini file Excel dan langsung mendownload
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0'); 
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');      // simpan file langsung ke output browser
        exit;       // hentikan eksekusi agar tidak lanjut render halaman lain
    } // end function export_excel

    // -- JS8 - Tugas3(m_user)  --
    public function export_pdf() {
        // ambil data user dari database beserta relasi level
        $user = UserModel::select('level_id','username','nama')
                    ->orderBy('level_id')     // urutkan berdasarkan level_id
                    ->orderBy('nama')     // lalu urutkan berdasarkan nama
                    ->with('level')          // ambil relasi level 
                    ->get();

        // buat PDF dari view 'user.export_pdf' dan kirim data $user ke view tersebut
        $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
        
        // set ukuran kertas menjadi A4 dan orientasi portrait (tegak)
        $pdf->setPaper('a4', 'portrait'); 

        // aktifkan opsi agar bisa render gambar dari URL (jika ada gambar dari internet)
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        
        // render PDF
        $pdf->render();

        // tampilkan PDF di browser (stream), nama file dinamis berdasarkan tanggal & jam
        return $pdf->stream('Data User '.date('Y-m-d H:i:s').'.pdf');
    }
}