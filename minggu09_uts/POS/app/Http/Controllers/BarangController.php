<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
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
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();

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
}