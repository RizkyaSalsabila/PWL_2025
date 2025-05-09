<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        // $data = DB::select('select * from m_user'); // Menampilkan semua data dari tabel 'm_user'
        // return view('user', ['data' => $data]);

        // JS3 - P6(Eloquent ORM)
        //tambah data user dengan Eloquent
        // $data =[
        //     'nama' => 'Pelanggan Pertama'
        // ];

        // UserModel::where('username', 'customer-1')->update($data);  //update data user

        // //mencoba akses model UserModel
        // $user = UserModel::all();       //ambil semua data dari tabel 'm_user'
        // return view('user', ['data' => $user]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_user'
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];

        // UserModel::create($data);

        // //mencoba akses model UserModel
        // $user = UserModel::all();       //ambil semua data dari tabel 'm_user'
        // return view('user', ['data' => $user]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 05* -------------------------------------

        //menampilkan halaman awal user 
            $breadcrumb = (object) [
                'title' => 'Daftar User',
                'list'  => ['Home', 'User']
            ];

            $page = (object) [
                'title' => 'Daftar User yang terdaftar dalam sistem'
            ];

            $activeMenu = 'user';   //set menu yang sedang aktif

            // JS5 - P4(filter)
            $level = LevelModel::all();

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
    
    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                        ->with('level');

        // JS5 - P4(filter)
        //filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
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
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm text-white">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - P1(tambah_ajax)
    public function create_ajax() {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')->with('level', $level);
    }

    // JS6 - P1(tambah_ajax)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer|exists:m_level,level_id',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

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

    // JS6 - P2(edit_ajax)
    //menampilkan halaman form edit user ajax
    public function edit_ajax(string $id) {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // JS6 - P2(edit_ajax)
    public function update_ajax(Request $request, $id)
     {
         // cek apakah request dari ajax
         if ($request->ajax() || $request->wantsJson()) {
             $rules = [
                 'level_id' => 'required|integer|exists:m_level,level_id',
                 'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                 'nama'     => 'required|max:100',
                 'password' => 'nullable|min:6|max:20'
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

    // JS6 - P3(hapus_ajax)
    public function confirm_ajax(string $id) {
        $user = UserModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
     }

    // JS6 - P3(hapus_ajax)
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

    // JS6 - (show_ajax)
    public function show_ajax(string $id) {
        $user = UserModel::with('level')->find($id);

        return view('user.show_ajax', ['user' => $user]);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 08* ------------------------------------- --
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

    public function export_excel() {
        //ambil data user beserta level yang akan di export
        $user = UserModel::select('level_id', 'username', 'nama', 'password')
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
}