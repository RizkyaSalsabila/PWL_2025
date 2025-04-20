<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KategoriController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_kategori(kategori_kode, kategori_nama, deskripsi, created_at) values(?, ?, ?, ?)', ['KT06', 'Perawatan', 'Produk untuk perawatan tubuh dan kecantikan', now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update m_kategori set kategori_nama = ? where kategori_kode = ?', ['Perawatan dan Kecantikan', 'KT06']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_kategori where kategori_kode = ?', ['KT06']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from m_kategori'); // Menampilkan semua data dari tabel 'm_kategori'
        // return view('kategori', ['data' => $data]);

        // JS3 - P5(Query Builder)
        //Menambahkan 1 data ke 'm_kategori'
       /*data = [
            'kode_kategori' => 'SNK',
            'nama_kategori' => 'Snack/Makanan Ringan',
            'created_at' => now()
        ];

        DB::table('m_kategori')->insert($data);
        return 'Insert data baru berhasil';*/

        //Mengupdate data di 'm_kategori'
       /*row = DB::table('m_kategori')->where('kode_kategori', 'SNK')->update(['nama_kategori' => 'Camilan']);
        return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';*/

        //Menghapus data yang sudah ada di 'm_kategori'
       /*row = DB::table('m_kategori')->where('kode_kategori', 'SNK')->delete();
        return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';*/

        //Menampilkan data di 'm_kategori'
        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_kategori'
        // $data = [
        //     'kategori_kode' => 'KT06',
        //     'kategori_nama' => 'Perawatan',
        //     'deskripsi' => 'Kategori untuk produk-produk perawatan tubuh dan kecantikan'
        // ];

        // KategoriModel::create($data);

        // //mencoba akses model BarangModel
        // $kategori = KategoriModel::all();       //ambil semua data dari tabel 'm_kategori'
        // return view('kategori', ['data' => $kategori]);
        // -----------------------------------------------------------------------------------------


        // ------------------------------------- *jobsheet 05* -------------------------------------
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list'  => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori';   //set menu yang sedang aktif

        return view(
            'kategori.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                ]
        );
    }

    // Ambil data kategori dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama', 'deskripsi');

        return DataTables::of($kategoris)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($kategori) {
                $btn  = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    public function create_ajax() {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode'  => 'required|string|max:10|unique:m_kategori,kategori_kode',    
                'kategori_nama'  => 'required|string|max:100',   
                'deskripsi'      => 'required|string|max:255'
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            KategoriModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }
    
        redirect('/');
    } 

    // JS6 - P2(edit_ajax) 
    //menampilkan halaman form edit kategori ajax
    public function edit_ajax(string $id) {
        $kategori = KategoriModel::find($id);

        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    // JS6 - P2(edit_ajax) 
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode'  => 'required|string|max:10|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',    
                'kategori_nama'  => 'required|string|max:100',   
                'deskripsi'      => 'required|string|max:200'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->update($request->all());
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
        $kategori = KategoriModel::find($id);

        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
     }

    // JS6 - P3(hapus_ajax)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if ($kategori) {
                $kategori->delete();
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
        $kategori = KategoriModel::find($id);

        return view('kategori.show_ajax', ['kategori' => $kategori]);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 08* ------------------------------------- --
    public function export_pdf() {
        // ambil data kategori dari database
        $kategori = KategoriModel::select('kategori_kode','kategori_nama', 'deskripsi')
                    ->orderBy('kategori_kode')     // lalu urutkan berdasarkan kode_kategori
                    ->get();

        // buat PDF dari view 'kategori.export_pdf' dan kirim data $kategori ke view tersebut
        $pdf = Pdf::loadView('kategori.export_pdf', ['kategori' => $kategori]);
        
        // set ukuran kertas menjadi A4 dan orientasi portrait (tegak)
        $pdf->setPaper('a4', 'portrait'); 

        // aktifkan opsi agar bisa render gambar dari URL (jika ada gambar dari internet)
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        
        // render PDF
        $pdf->render();

        // tampilkan PDF di browser (stream), nama file dinamis berdasarkan tanggal & jam
        return $pdf->stream('Data Kategori '.date('Y-m-d H:i:s').'.pdf');
    }

    public function export_excel() {
        //ambil data kategori yang akan di export
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama', 'deskripsi')
                    ->get();

        // load library excel atau PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif untuk digunakan

        // set header kolom di baris pertama
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');
        $sheet->setCellValue('D1', 'Deskripsi Kategori');

        // buat teks di header menjadi bold
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);   // bold header

        $no = 1;         // nomor data dimulai dari 1
        $baris = 2;      // baris data dimulai dari baris ke 2
        // loop untuk menuliskan data ke dalam sheet
        foreach ($kategori as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);    // No
            $sheet->setCellValue('B' . $baris, $value->kategori_kode);    // Kode Kategori
            $sheet->setCellValue('C' . $baris, $value->kategori_nama);    // Nama Kategori
            $sheet->setCellValue('D' . $baris, $value->deskripsi);    // Deskripsi
            $baris++;   // pindah ke baris berikutnya
            $no++;      // tambah nomor urut
        }

        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        // set nama sheet
        $sheet->setTitle('Data Kategori'); // set title sheet

        // buat writer untuk menyimpan spreadsheet ke format Excel (.xlsx)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Kategori ' . date('Y-m-d H:i:s') . '.xlsx';

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