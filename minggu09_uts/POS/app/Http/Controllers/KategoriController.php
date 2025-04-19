<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
}