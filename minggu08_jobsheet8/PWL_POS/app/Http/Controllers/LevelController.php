<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class LevelController extends Controller
{
    // public function index()
    // {
    //     //KODE AWAL
    //     // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
    //     // return 'Insert data baru berhasil';

    //     //KODE KEDUA
    //     // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']); 
    //     // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    //     //KODE KETIGA
    //     // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']); // Menghapus data dengan kode = 'CUS'
    //     // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    //     //KODE BARU
    //     $data = DB::select('select * from m_level'); // Menampilkan semua data dari tabel 'm_level'
    //     return view('level', ['data' => $data]);
    // }


    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    // JS5 - Tugas(m_level)
    //menampilkan halaman awal level 
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list'  => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';   //set menu yang sedang aktif

        $level = LevelModel::all();     //ambil data level untuk filter level

        return view(
            'level.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                'level' => $level
                ]
        );
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($level) {
                // $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // $btn .= ' <a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // $btn .= ' <form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                //     . csrf_field()
                //     . method_field('DELETE')
                //     . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                //     . '</form>';

                // JS6 - Tugas(m_level) 
                $btn  = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //menampilkan halaman form tambah level
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list'  => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level Baru'
        ];

        $activeMenu = 'level';           //set menu yang sedang aktif

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    //menyimpan data level baru
    public function store(Request $request) {
        $request->validate([
            'level_kode'  => 'required|string|max:10|unique:m_level,level_kode',     //level_kode harus diisi, berupa string, maks 8 karakter, bernilai unik di tabel m_level kolom level_kode
            'level_nama'  => 'required|string|max:100',   //level_nama harus diisi, berupa string, maks 100 karakter
        ]);

        LevelModel::create([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil disimpan');
    }  
 
    //menampilkan detail level
    public function show(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list'  => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];

        $activeMenu = 'level';       //set menu yang sedang aktif

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //menampilkan halaman form edit level
    public function edit(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list'  => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level';       //set menu yang sedang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //menyimpan perubahan data level 
    public function update(Request $request, string $id) {
        $request->validate([
            'level_kode'  => 'required|string|max:10|unique:m_level,level_kode,'.$id.',level_id',    //level_kode harus diisi, berupa string, maks 8 karakter, bernilai unik di tabel m_level kolom level_kode
            'level_nama'  => 'required|string|max:100',   //level_nama harus diisi, berupa string, maks 100 karakter
        ]);

        LevelModel::find($id)->update([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil diubah');
    } 

    //menghapus data level
    public function destroy(string $id) {
        $check = LevelModel::find($id);
        if (!$check) {  //untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
            return redirect('/level')->with('error', 'Data Level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);    //Hapus data level

            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            //jika terjadi error ketika menghapus data,
            //redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - Tugas(m_level)
    public function create_ajax() {
        return view('level.create_ajax');
    }

    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                // 'level_kode'  => 'required|string|max:10|unique:m_level,level_kode',     //level_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_level kolom level_kode
                // 'level_nama'  => 'required|string|max:100',   //level_nama harus diisi, berupa string, maks 100 karakter

                // -- JS8 - Tugas(m_level) --
                'level_kode' => ['required', 'string', 'max:10', 'unique:m_level,level_kode'], // level_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_level kolom level_kode
                'level_nama' => ['required', 'string', 'max:100'],
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            LevelModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data level berhasil disimpan'
            ]);
        }
    
        redirect('/');
    } 

    // JS6 - Tugas(m_level) 
    //menampilkan halaman form edit level ajax
    public function edit_ajax(string $id) {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
            //    'level_kode'  => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',     
            //    'level_nama'  => 'required|string|max:100',  

            // -- JS8 - Tugas(m_level) --
            'level_kode' => ['required', 'string', 'max:10', 'unique:m_level,level_kode,' . $id . ',level_id'], 
            'level_nama' => ['required', 'string', 'max:100'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $level = LevelModel::find($id);
            if ($level) {
                $level->update($request->all());
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

    // JS6 - Tugas(m_level)
    public function confirm_ajax(string $id) {
        $level = LevelModel::find($id);

        return view('level.confirm_ajax', ['level' => $level]);
     }

    // JS6 - Tugas(m_level)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $level = LevelModel::find($id);
            if ($level) {
                $level->delete();
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
    // -- JS8 - Tugas(m_level)  --
    public function import() {
        return view('level.import');
    }

    // -- JS8 - Tugas(m_level)  --
    public function import_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                //validasi file harus xls atau xlsx, max 1MB
                'file_level' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgFiled'  => $validator->errors()
                ]);
            }

            $file = $request->file('file_level');      //ambil file dari request

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
                            'level_kode' => $value['A'],
                            'level_nama' => $value['B'],
                            'created_at' => now(),
                        ];
                    }
                }

                //insert data ke database, jika data sudah ada maka diabaikan
                if (count($insert) > 0) {
                    LevelModel::insertOrIgnore($insert);
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

    // -- JS8 - Tugas2(m_level) --
    public function export_excel() {
        //ambil data level yang akan di export
        $level = LevelModel::select('level_kode', 'level_nama')
                    ->get();

        // load library excel atau PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif untuk digunakan

        // set header kolom di baris pertama
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Level');
        $sheet->setCellValue('C1', 'Nama Level');

        // buat teks di header menjadi bold
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);   // bold header

        $no = 1;         // nomor data dimulai dari 1
        $baris = 2;      // baris data dimulai dari baris ke 2
        // loop untuk menuliskan data ke dalam sheet
        foreach ($level as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);    // No
            $sheet->setCellValue('B' . $baris, $value->level_kode);    // Kode Level
            $sheet->setCellValue('C' . $baris, $value->level_nama);    // Nama Level
            $baris++;   // pindah ke baris berikutnya
            $no++;      // tambah nomor urut
        }

        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        // set nama sheet
        $sheet->setTitle('Data Level'); // set title sheet

        // buat writer untuk menyimpan spreadsheet ke format Excel (.xlsx)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Level ' . date('Y-m-d H:i:s') . '.xlsx';

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

    // -- JS8 - Tugas3(m_level) --
    public function export_pdf() {
        // ambil data level dari database
        $level = LevelModel::select('level_kode','level_nama')
                    ->orderBy('level_kode')     // lalu urutkan berdasarkan level_kode
                    ->get();

        // buat PDF dari view 'level.export_pdf' dan kirim data $level ke view tersebut
        $pdf = Pdf::loadView('level.export_pdf', ['level' => $level]);
        
        // set ukuran kertas menjadi A4 dan orientasi portrait (tegak)
        $pdf->setPaper('a4', 'portrait'); 

        // aktifkan opsi agar bisa render gambar dari URL (jika ada gambar dari internet)
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
       
        // render PDF
        $pdf->render();

        // tampilkan PDF di browser (stream), nama file dinamis berdasarkan tanggal & jam
        return $pdf->stream('Data Level '.date('Y-m-d H:i:s').'.pdf');
    }
}