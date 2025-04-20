<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BarangController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_barang(kategori_id, barang_kode, barang_nama, harga_beli, harga_jual, created_at) values(?, ?, ?, ?, ?, ?)', [5, 'BR03E', 'Makaroni Pedas', 10000, 12000, now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update m_barang set harga_jual = ? where barang_kode = ?', [15000, 'BR03E']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_barang where barang_kode = ?', ['BR03E']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from m_barang'); // Menampilkan semua data dari tabel 'm_barang'
        // return view('barang', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_barang'
        // $data = [
        //     'kategori_id' => 6,
        //     'barang_kode' => 'BR01F',
        //     'barang_nama' => 'Sabun Mandi',
        //     'harga_beli' => 2500,
        //     'harga_jual' => 3500
        // ];

        // BarangModel::create($data);

        // //mencoba akses model BarangModel
        // $barang = BarangModel::all();       //ambil semua data dari tabel 'm_barang'
        // return view('barang', ['data' => $barang]);
        // -----------------------------------------------------------------------------------------


        // ------------------------------------- *jobsheet 05* -------------------------------------

        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list'  => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';   //set menu yang sedang aktif

        $kategori = KategoriModel::all();     //ambil data kategori untuk filter kategori

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

    // Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'kategori_id')
                        ->with('kategori');

        //filter data barang berdasarkan kategori_id
        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barangs)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($barang) {
                // JS6 - P1(tambah_ajax)
                $btn  = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm text-white">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - P1(tambah_ajax)
    public function create_ajax() {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    // JS6 - P1(tambah_ajax)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode',     //barang_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_barang kolom barang_kode
                'barang_nama'  => 'required|string|max:100',   //barang_nama harus diisi, berupa string, maks 100 karakter
                'harga_beli'   => 'required|integer',     //harga_beli harus diisi, berupa integer
                'harga_jual'   => 'required|integer',     //harga_jual harus diisi, berupa integer
                'kategori_id'  => 'required|integer|exists:m_kategori,kategori_id',     //kategori_id harus diisi, berupa integer
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

    // JS6 - P2(edit_ajax)
    //menampilkan halaman form edit barang ajax
    public function edit_ajax(string $id) {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();

        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    // JS6 - P2(edit_ajax)
    public function update_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
               'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
               'barang_nama'  => 'required|string|max:100', 
               'harga_beli'   => 'required|integer', 
               'harga_jual'   => 'required|integer',   
               'kategori_id'  => 'required|integer|exists:m_kategori,kategori_id',  
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

    // JS6 - P3(hapus_ajax)
    public function confirm_ajax(string $id) {
        $barang = BarangModel::find($id);

        return view('barang.confirm_ajax', ['barang' => $barang]);
     }

    // JS6 - P3(hapus_ajax)
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
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
        $barang = BarangModel::with('kategori')->find($id);

        return view('barang.show_ajax', ['barang' => $barang]);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 08* ------------------------------------- --
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

    public function export_excel() {
        //ambil data barang beserta kategori yang akan di export
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
                    ->orderBy('kategori_id')        // urutkan berdasarkan kategori
                    ->with('kategori')              // ambil relasi kategori
                    ->get();

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

        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

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
}