<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\SupplierModel;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class StokController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into t_stok(barang_id, user_id, supplier_id, stok_tanggal, stok_jumlah, created_at) values(?, ?, ?, ?, ?, ?)', [10, 1, 1, now(), 100, now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update t_stok set stok_jumlah = ? where stok_id = ?', [20, 10]);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from t_stok where stok_id = ?', [10]);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from t_stok'); // Menampilkan semua data dari tabel 't_stok'
        // return view('stok', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 't_stok'
        // $data = [
        //     'supplier_id' => 2,
        //     'barang_id' => 3,
        //     'user_id' => 1,
        //     'stok_tanggal' => now(),
        //     'stok_jumlah' => 45
        // ];

        // StokModel::create($data);

        // //mencoba akses model StokModel
        // $stok = StokModel::all();       //ambil semua data dari tabel 't_stok'
        // return view('stok', ['data' => $stok]);
        // -----------------------------------------------------------------------------------------


        // ------------------------------------- *jobsheet 05* -------------------------------------

        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list'  => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok';   //set menu yang sedang aktif

        $barang = BarangModel::all();

        return view(
            'stok.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                'barang' => $barang
                ]
        );
    }

    // Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $stoks = StokModel::select('stok_id', 'stok_tanggal', 'stok_jumlah', 'supplier_id', 'barang_id', 'user_id')
                        ->with(['supplier', 'barang', 'user']);

        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }
                
        return DataTables::of($stoks)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($stok) {
                // JS6 - P1(tambah_ajax)
                $btn  = '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm text-white">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/stok/' . $stok->stok_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - P1(tambah_ajax)
    public function create_ajax() {
        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        return view(
            'stok.create_ajax',
            [
                'supplier'  => $supplier,
                'barang'  => $barang,
                'user'  => $user
            ]
        );
    }

    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer|min:1',
                'supplier_id' => 'required|integer|exists:m_supplier,supplier_id',
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'user_id' => 'required|integer|exists:m_user,user_id'
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            StokModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data stok berhasil disimpan'
            ]);
        }
    
        redirect('/');
    }

    // JS6 - P2(edit_ajax)
    //menampilkan halaman form edit stok ajax
    public function edit_ajax(string $id) {
        $stok = StokModel::find($id);

        $supplier = SupplierModel::select('supplier_id', 'supplier_nama')->get();
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        return view(
            'stok.edit_ajax', 
            [
                'stok' => $stok,
                'supplier' => $supplier,
                'barang' => $barang,
                'user' => $user
            ]
        );
    }

    // JS6 - P2(edit_ajax)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [ 
                'stok_tanggal' => 'required|date',
                'stok_jumlah' => 'required|integer|min:1',
                'supplier_id' => 'required|integer|exists:m_supplier,supplier_id',
                'barang_id' => 'required|integer|exists:m_barang,barang_id',
                'user_id' => 'required|integer|exists:m_user,user_id'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $stok = StokModel::find($id);
            if ($stok) {
                $stok->update($request->all());
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
        $stok = StokModel::find($id);

        return view('stok.confirm_ajax', ['stok' => $stok]);
     }

    // JS6 - P3(hapus_ajax)
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $stok = StokModel::find($id);
            if ($stok) {
                $stok->delete();
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
        $stok = StokModel::with(['supplier', 'barang', 'user'])->find($id);

        return view('stok.show_ajax', ['stok' => $stok]);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 08* ------------------------------------- --
    public function export_pdf(){
        $stok = StokModel::select(
            'stok_tanggal',
            'stok_jumlah',
            'supplier_id',
            'barang_id',
            'user_id'
        )
        ->orderBy('barang_id')
        ->orderBy('stok_tanggal')
        ->with(['supplier', 'barang', 'user'])
        ->get();

        $pdf = PDF::loadView('stok.export_pdf', ['stok' => $stok]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Stok Barang '.date('Y-m-d H-i-s').'.pdf');
    }

    public function export_excel() {
        //ambil data stok beserta relasinya yang akan di export
        $stok = StokModel::select('stok_tanggal', 'stok_jumlah', 'supplier_id', 'barang_id', 'user_id')
                    ->orderBy('stok_tanggal')        // urutkan berdasarkan stok_tanggal
                    ->with(['supplier', 'barang', 'user'])              // ambil relasi 
                    ->get();

        // load library excel atau PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif untuk digunakan

        // set header kolom di baris pertama
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Jumlah');
        $sheet->setCellValue('D1', 'Nama Supplier');
        $sheet->setCellValue('E1', 'Nama Barang');
        $sheet->setCellValue('F1', 'Nama User');

        // buat teks di header menjadi bold
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);   // bold header

        $no = 1;         // nomor data dimulai dari 1
        $baris = 2;      // baris data dimulai dari baris ke 2
        // loop untuk menuliskan data ke dalam sheet
        foreach ($stok as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);  
            $sheet->setCellValue('B' . $baris, $value->stok_tanggal); 
            $sheet->setCellValue('C' . $baris, $value->stok_jumlah);   
            $sheet->setCellValue('D' . $baris, $value->supplier->supplier_nama);   
            $sheet->setCellValue('E' . $baris, $value->barang->barang_nama);  
            $sheet->setCellValue('F' . $baris, $value->user->nama); 
            $baris++;   // pindah ke baris berikutnya
            $no++;      // tambah nomor urut
        }

        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        // set nama sheet
        $sheet->setTitle('Data Stok'); // set title sheet

        // buat writer untuk menyimpan spreadsheet ke format Excel (.xlsx)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Stok ' . date('Y-m-d H:i:s') . '.xlsx';

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