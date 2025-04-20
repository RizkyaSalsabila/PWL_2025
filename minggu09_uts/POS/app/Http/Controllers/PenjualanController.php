<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel;
use App\Models\StokModel;
use App\Models\PenjualanModel;
use App\Models\BarangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PenjualanController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into t_penjualan(user_id, pembeli, penjualan_kode, penjualan_tanggal, created_at) values(?, ?, ?, ?, ?)', [3, 'Alfiyatur Rohmah', 'PNJ11', now(), now()]);
        // return 'Insert data baru berhasil';

        // KODE KEDUA
        // $row = DB::update('update t_penjualan set pembeli = ? where penjualan_kode = ?', ['Alfiyatur Nur Rohmah', 'PNJ11']);
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from t_penjualan where penjualan_kode = ?', ['PNJ11']);
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from t_penjualan'); // Menampilkan semua data dari tabel 't_penjualan'
        // return view('penjualan', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 't_penjualan'
        // $data = [
        //     'user_id' => 2,
        //     'pembeli' => 'Budi Santoso',
        //     'penjualan_kode' => 'PNJ11',
        //     'penjualan_tanggal' => now()
        // ];

        // PenjualanModel::create($data);

        // //mencoba akses model BarangModel
        // $penjualan = PenjualanModel::all();       //ambil semua data dari tabel 't_penjualan'
        // return view('penjualan', ['data' => $penjualan]);
        // -----------------------------------------------------------------------------------------

        $breadcrumb = (object) [
            'title' => 'Transaksi Penjualan',
            'list'  => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';   //set menu yang sedang aktif
        $user = UserModel::whereIn('level_id', [1, 2, 3])->get();
        // $penjualan = PenjualanModel::all();     //ambil data level untuk filter level

        return view(
            'penjualan.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page'       => $page,
                'activeMenu' => $activeMenu,
                'user'       => $user
                ]
        );
    }  

    // Ambil data penjualan dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $penjualans = PenjualanModel::select('penjualan_id', 'penjualan_kode', 'penjualan_tanggal', 'pembeli', 'user_id')
                        ->with('user');

        //filter data penjualan berdasarkan user_id
        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($penjualan) {
                // JS6 - P1(tambah_ajax)
                $btn  = '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm text-white">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/struk_pdf') . '" target="_blank" class="btn btn-secondary btn-sm">Cetak Struk</a>';

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - P1(tambah_ajax)
    public function create_ajax() {
        $barang = BarangModel::whereIn('barang_id', function ($query) {
            $query->select('barang_id')
                ->from('t_stok')
                ->where('stok_jumlah', '>', 0);
        })->get(); // cuma barang yang ada stoknya yang ditampilin

        $user = Auth::user(); // ambil user yang login
        $kode = 'PNJ0' . PenjualanModel::orderBy('penjualan_id', 'desc')->value('penjualan_id') + 1;

        return view('penjualan.create_ajax')
             ->with('barang', $barang)
             ->with('user', $user)
             ->with('kode', $kode);
    }

    // JS6 - P1(tambah_ajax)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|exists:m_user,user_id',
                'pembeli' => 'required|max:40',
                'penjualan_kode' => 'required|max:20',
                'penjualan_tanggal' => 'required|date',
                'barang_id' => 'required|array',
                'harga' => 'required|array',
                'jumlah' => 'required|array'   
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            try {
                DB::beginTransaction();

                // Simpan ke t_penjualan
                $penjualan = PenjualanModel::create([
                    'user_id' => $request->user_id,
                    'pembeli' => $request->pembeli,
                    'penjualan_kode' => $request->penjualan_kode,
                    'penjualan_tanggal' => $request->penjualan_tanggal,
                ]);

                // Loop dan simpan ke t_penjualan_detail
                foreach ($request->barang_id as $i => $barang_id) {
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $barang_id,
                        'harga' => $request->harga[$i],
                        'jumlah' => $request->jumlah[$i],
                    ]);

                    // kurangi stok
                    $stok = StokModel::where('barang_id', $barang_id)->first();
                    if ($stok) {
                        if ($stok->stok_jumlah >= $request->jumlah[$i]) {
                            $stok->stok_jumlah -= $request->jumlah[$i];
                            $stok->save();
                        } else {
                            // rollback jika stok tidak mencukupi
                            DB::rollBack();
                            return response()->json([
                                'status' => false,
                                'message' => 'Stok barang ' . $stok->barang->barang_nama . ' tidak mencukupi'
                            ]);
                        }
                    } else {
                        // rollback jika stok tidak ditemukan
                        DB::rollBack();
                        return response()->json([
                            'status' => false,
                            'message' => 'Stok untuk barang tidak ditemukan'
                        ]);
                    }
                }
 
                DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data Penjualan dan Detail berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
            ]);
        }
    }
    return redirect('/');
    }

    public function store_detail_ajax(Request $request)
    {
        $rules = [
            'harga' => 'required|numeric|min:1',
            'jumlah' => 'required|integer|min:1',
            'penjualan_id' => 'required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ]);
        }

        PenjualanDetailModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Transaksi Penjualan Berhasil disimpan'
        ]);
    }

    // JS6 - P2(edit_ajax)
    //menampilkan halaman form edit penjualan ajax
    public function edit_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);
        $barang = BarangModel::all();
        $user = Auth::user();

        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'barang' => $barang, 'user' => $user]);
    }

    // JS6 - P2(edit_ajax)
    public function update_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_tanggal'  => 'required|date',   
                'pembeli'            => 'required|string|max:50',   
                'user_id'            => 'required|integer|exists:m_user,user_id',  
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            try {
                $penjualan = PenjualanModel::findOrFail($id);
                $penjualan->update([
                    'user_id' => $request->user_id,
                    'pembeli' => $request->pembeli,
                    'penjualan_tanggal' => $request->penjualan_tanggal
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil diperbarui.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan gagal diperbarui.',
                    'msgField' => ['exception' => [$e->getMessage()]]
                ]);
            }
        }
 
        return redirect('/');
    }

    // JS6 - P3(hapus_ajax)
    public function confirm_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);
        $penjualanDetail = PenjualanDetailModel::find($penjualan->penjualan_id);

        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan, 'penjualanDetail' => $penjualanDetail]);
     }

    // JS6 - P3(hapus_ajax)
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {

                try {
                    // Hapus dulu semua detail yang terkait
                    $penjualan->detail()->delete(); // Pastikan relasi 'detail' ada di model
                    // Baru hapus data induknya
                    $penjualan->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak bisa dihapus'
                    ]);
                }
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
        $penjualan = PenjualanModel::with('user')->find($id);
        $detail = PenjualanDetailModel::where('penjualan_id', $penjualan->id)->get();

        return view('penjualan.show_ajax', ['penjualan' => $penjualan, 'detail' => $detail]);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 08* ------------------------------------- --
    public function export_pdf(){
        $penjualan = PenjualanModel::select(
            'penjualan_kode',
            'penjualan_tanggal',
            'pembeli',
            'user_id'
        )
            ->orderBy('penjualan_kode')
            ->with('user')
            ->get();

        $detail = PenjualanDetailModel::all();

        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = PDF::loadView('penjualan.export_pdf', ['penjualan' => $penjualan,  'detail' => $detail]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Penjualan '.date('Y-m-d H-i-s').'.pdf');
    }

    public function export_excel() {
        //ambil data penjualan beserta kategori yang akan di export
        $penjualan = PenjualanModel::select('penjualan_kode', 'penjualan_tanggal', 'pembeli', 'user_id')
                    ->orderBy('penjualan_kode')        // urutkan berdasarkan penjualan_kode
                    ->with('user')              // ambil relasi 
                    ->get();

        // load library excel atau PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif untuk digunakan

        // set header kolom di baris pertama
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Tanggal Penjualan');
        $sheet->setCellValue('D1', 'Pembeli');
        $sheet->setCellValue('E1', 'Nama Petugas');

        // buat teks di header menjadi bold
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);   // bold header

        $no = 1;         // nomor data dimulai dari 1
        $baris = 2;      // baris data dimulai dari baris ke 2
        // loop untuk menuliskan data ke dalam sheet
        foreach ($penjualan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);  
            $sheet->setCellValue('B' . $baris, $value->penjualan_kode); 
            $sheet->setCellValue('C' . $baris, $value->penjualan_nama);   
            $sheet->setCellValue('D' . $baris, $value->pembeli);   
            $sheet->setCellValue('E' . $baris, $value->user->nama); 
            $baris++;   // pindah ke baris berikutnya
            $no++;      // tambah nomor urut
        }

        // atur ukuran kolom agar menyesuaikan isi secara otomatis
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        // set nama sheet
        $sheet->setTitle('Data Penjualan'); // set title sheet

        // buat writer untuk menyimpan spreadsheet ke format Excel (.xlsx)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';

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

    public function struk_pdf($id) {
        $penjualan = PenjualanModel::with(['penjualan_detail.barang', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('penjualan.struk_pdf', compact('penjualan'));
        $pdf->setPaper([0, 0, 226.77, 600], 'portrait'); // ukuran struk kecil
        return $pdf->stream('Struk_Penjualan_' . $penjualan->penjualan_kode . '.pdf');
    }
}