<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


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
            'list'  => ['Home', 'Transaksi']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';   //set menu yang sedang aktif

        $penjualan = PenjualanModel::all();     //ambil data level untuk filter level

        return view(
            'penjualan.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page'       => $page,
                'activeMenu' => $activeMenu,
                'penjualan' => $penjualan
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
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - P1(tambah_ajax)
    public function create_ajax() {
        $user = UserModel::select('user_id', 'nama')->get();

        return view('penjualan.create_ajax')->with('user', $user);
    }

    // JS6 - P1(tambah_ajax)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'  => 'required|string|max:20|unique:t_penjualan,penjualan_kode',     
                'penjualan_tanggal'  => 'required|date',   
                'pembeli'   => 'required|string|max:50',   
                'user_id'   => 'required|integer|exists:m_user,user_id',    
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            PenjualanModel::create($request->all()); 

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan'
            ]);
        }
    
        redirect('/');
    }

    // JS6 - P2(edit_ajax)
    //menampilkan halaman form edit penjualan ajax
    public function edit_ajax(string $id) {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::select('user_id', 'nama')->get();

        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'user' => $user]);
    }

    // JS6 - P2(edit_ajax)
    public function update_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode'     => 'required|string|max:20|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',     
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

            $check = PenjualanModel::find($id);
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
        $penjualan = PenjualanModel::find($id);

        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
     }

    // JS6 - P3(hapus_ajax)
    public function delete_ajax(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
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
        $penjualan = PenjualanModel::with('user')->find($id);

        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
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
            ->orderBy('penjualan_id')
            ->orderBy('penjualan_kode')
            ->get();


        // use Barryvdh\DomPDF\Facade\Pdf;
        $pdf = PDF::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('A4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render(); // render pdf

        return $pdf->stream('Data Penjualan '.date('Y-m-d H-i-s').'.pdf');
    }
}