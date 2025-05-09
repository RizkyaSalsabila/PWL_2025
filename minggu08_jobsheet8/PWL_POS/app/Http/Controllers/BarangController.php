<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    // JS5 - Tugas(m_barang)
    //menampilkan halaman awal barang 
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';   //set menu yang sedang aktif

        // $kategori = KategoriModel::all();     //ambil data kategori untuk filter kategori

        // -- JS8 - P1(7) --
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();       //ambil data kategori untuk filter kategori berdasarkan kolom 'kategori_id' dan 'nama_kategori'

        return view(
            'barang.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                'kategori' => $kategori
                ]
        );
    }

    // Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
                        ->with('kategori');

        // -- JS8 - P1(7) --
        $kategori_id = $request->input('filter_kategori'); 
        if(!empty($kategori_id)) {             
            $barangs->where('kategori_id', $kategori_id);       
        }

        //filter data user berdasarkan kategori_id
        // if ($request->kategori_id) {
        //     $barangs->where('kategori_id', $request->kategori_id);
        // }

        return DataTables::of($barangs)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($barang) {
                // $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // $btn .= ' <a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // $btn .= ' <form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                //     . csrf_field()
                //     . method_field('DELETE')
                //     . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                //     . '</form>';

                // JS6 - Tugas(m_barang)
                $btn  = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //menampilkan halaman form tambah barang
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list'  => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang Baru'
        ];

        $kategori = KategoriModel::all();     //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'barang';           //set menu yang sedang aktif

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
 
    //menyimpan data barang baru
    public function store(Request $request) {
        $request->validate([
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',     //barang_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_barang kolom barang_kode
            'barang_nama'  => 'required|string|max:100',   //barang_nama harus diisi, berupa string, maks 100 karakter
            'harga_beli'   => 'required|integer',     //harga_beli harus diisi, berupa integer
            'harga_jual'   => 'required|integer',     //harga_jual harus diisi, berupa integer
            'kategori_id'  => 'required|integer',     //kategori_id harus diisi, berupa integer
        ]);

        BarangModel::create([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_beli'   => $request->harga_beli,  
            'harga_jual'   => $request->harga_jual,   
            'kategori_id'  => $request->kategori_id
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil disimpan');
    }  
 
    //menampilkan detail barang
    public function show(string $id) {
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang';       //set menu yang sedang aktif

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
 
    //menampilkan halaman form edit barang
    public function edit(string $id) {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang';       //set menu yang sedang aktif

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //menyimpan perubahan data barang 
    public function update(Request $request, string $id) {
        $request->validate([
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,'.$id.',barang_id',     
            'barang_nama'  => 'required|string|max:100',   
            'harga_beli'   => 'required|integer',     
            'harga_jual'   => 'required|integer',     
            'kategori_id'  => 'required|integer', 
        ]);

        BarangModel::find($id)->update([
            'barang_kode'  => $request->barang_kode,
            'barang_nama'  => $request->barang_nama,
            'harga_beli'   => $request->harga_beli,  
            'harga_jual'   => $request->harga_jual,   
            'kategori_id'  => $request->kategori_id
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil diubah');
    } 

    //menghapus data barang
    public function destroy(string $id) {
        $check = BarangModel::find($id);
        if (!$check) {  //untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Data Barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);    //Hapus data barang

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            //jika terjadi error ketika menghapus data,
            //redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // -- ----------------------------------------------------------------------------------------- --


    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - Tugas(m_barang)
    public function create_ajax() {
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();

        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    // JS6 - Tugas(m_barang)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                // 'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',     //barang_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_barang kolom barang_kode
                // 'barang_nama'  => 'required|string|max:100',   //barang_nama harus diisi, berupa string, maks 100 karakter
                // 'harga_beli'   => 'required|integer',     //harga_beli harus diisi, berupa integer
                // 'harga_jual'   => 'required|integer',     //harga_jual harus diisi, berupa integer
                // 'kategori_id'  => 'required|integer',     //kategori_id harus diisi, berupa integer
                
                // -- JS8 - P1(7) --
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'], 
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode'],                 
                'barang_nama' => ['required', 'string', 'max:100'],                 
                'harga_beli' => ['required', 'numeric'],                
                'harga_jual' => ['required', 'numeric'], 
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            BarangModel::create($request->all()); 

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }
    
        redirect('/');
    }    

    // JS6 - Tugas(m_barang)
    //menampilkan halaman form edit barang ajax
    public function edit_ajax(string $id) {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();

        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    // JS6 - Tugas(m_barang) 
    public function update_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
            //    'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            //    'barang_nama'  => 'required|string|max:100', 
            //    'harga_beli'   => 'required|integer', 
            //    'harga_jual'   => 'required|integer',   
            //    'kategori_id'  => 'required|integer',  

            // -- JS8 - P1(7) --
            'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'], 
            'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode,' . $id . ',barang_id'],                 
            'barang_nama' => ['required', 'string', 'max:100'],                 
            'harga_beli' => ['required', 'numeric'],                
            'harga_jual' => ['required', 'numeric'], 
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = BarangModel::find($id);
            if ($check) {
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

    // JS6 - Tugas(m_barang)
     public function confirm_ajax(string $id) {
        $barang = BarangModel::find($id);

        return view('barang.confirm_ajax', ['barang' => $barang]);
     }

    // JS6 - Tugas(m_barang)
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {      // jika sudah ditemukan
                $barang->delete();      // barang di hapus
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
    // -- JS8 - P1(7) --
    public function import() {
        return view('barang.import');
    }

    // -- JS8 - P1(7) --
    public function import_ajax(Request $request) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                //validasi file harus xls atau xlsx, max 1MB
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Validasi Gagal',
                    'msgFiled'  => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');      //ambil file dari request

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
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli' => $value['D'],
                            'harga_jual' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }

                //insert data ke database, jika data sudah ada maka diabaikan
                if (count($insert) > 0) {
                    BarangModel::insertOrIgnore($insert);
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

    // -- JS8 - P2(3 - 8) --
    // -- JS8 - P2(4) --
    public function export_excel() {
        //ambil data barang beserta kategori yang akan di export
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
                    ->orderBy('kategori_id')        // urutkan berdasarkan kategori
                    ->with('kategori')              // ambil relasi kategori
                    ->get();

        // -- JS8 - P2(5) --
        // load library excel atau PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif untuk digunakan

        // set header kolom di baris pertama
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');

        // buat teks di header menjadi bold
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);   // bold header

        // -- JS8 - P2(6) --
        $no = 1;         // nomor data dimulai dari 1
        $baris = 2;      // baris data dimulai dari baris ke 2
        // loop untuk menuliskan data ke dalam sheet
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);    // No
            $sheet->setCellValue('B' . $baris, $value->barang_kode);    // Kode Barang
            $sheet->setCellValue('C' . $baris, $value->barang_nama);    // Nama Barang
            $sheet->setCellValue('D' . $baris, $value->harga_beli);     // Harga Beli
            $sheet->setCellValue('E' . $baris, $value->harga_jual);     // Harga Jual
            $sheet->setCellValue('F' . $baris, $value->kategori->nama_kategori); // ambil nama kategori dari relasi
            $baris++;   // pindah ke baris berikutnya
            $no++;      // tambah nomor urut
        }

        // -- JS8 - P2(7) --
        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        // -- JS8 - P2(8) --
        // set nama sheet
        $sheet->setTitle('Data Barang'); // set title sheet

        // buat writer untuk menyimpan spreadsheet ke format Excel (.xlsx)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date('Y-m-d H:i:s') . '.xlsx';

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

    // -- JS8 - P3(4) --
    public function export_pdf() {
        // ambil data barang dari database beserta relasi kategori
        $barang = BarangModel::select('kategori_id','barang_kode','barang_nama','harga_beli','harga_jual')
                    ->orderBy('kategori_id')     // urutkan berdasarkan kategori_id
                    ->orderBy('barang_kode')     // lalu urutkan berdasarkan barang_kode
                    ->with('kategori')          // ambil relasi kategori 
                    ->get();

        // buat PDF dari view 'barang.export_pdf' dan kirim data $barang ke view tersebut
        $pdf = Pdf::loadView('barang.export_pdf', ['barang' => $barang]);
        
        // set ukuran kertas menjadi A4 dan orientasi portrait (tegak)
        $pdf->setPaper('a4', 'portrait'); 

        // aktifkan opsi agar bisa render gambar dari URL (jika ada gambar dari internet)
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
       
        // render PDF
        $pdf->render();

        // tampilkan PDF di browser (stream), nama file dinamis berdasarkan tanggal & jam
        return $pdf->stream('Data Barang '.date('Y-m-d H:i:s').'.pdf');
    }
}