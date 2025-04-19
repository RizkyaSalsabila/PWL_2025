<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index() {
        // ------------------------------------- *jobsheet 03* -------------------------------------
        // JS3 - P4(DB_FACADE)
        //KODE AWAL
        // DB::insert('insert into m_supplier(supplier_kode, supplier_nama, supplier_alamat, supplier_no_hp, created_at) values(?, ?, ?, ?, ?)', ['SUP004', 'CV. Berkah Abadi', 'Jl. Gatot Subroto No. 21, Sidoarjo',  '081322334455', now()]);
        // return 'Insert data baru berhasil';

        // // KODE KEDUA
        // $row = DB::update('update m_supplier set supplier_nama = ? where supplier_kode = ?', ['PT. Maju Lancar', 'SUP004']); 
        // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

        // KODE KETIGA
        // $row = DB::delete('delete from m_supplier where supplier_kode = ?', ['SUP004']); // Menghapus data dengan kode = 'SUP004'
        // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

        //KODE BARU
        // $data = DB::select('select * from m_supplier'); // Menampilkan semua data dari tabel 'm_supplier'
        // return view('supplier', ['data' => $data]);
        // -----------------------------------------------------------------------------------------

        // ------------------------------------- *jobsheet 04* -------------------------------------
        //menambahkan data baru ke 'm_supplier'
        // $data = [
        //     'supplier_kode'   => 'SUP004',
        //     'supplier_nama'   => 'PT. Sumber Rezeki',
        //     'supplier_alamat' => 'Jl. Industri No. 12, Malang',
        //     'supplier_no_hp'  => '081234567890'
        // ];

        // SupplierModel::create($data);

        // //mencoba akses model SupplierModel
        // $supplier = SupplierModel::all();       //ambil semua data dari tabel 'm_supplier'
        // return view('supplier', ['data' => $supplier]);
         // -----------------------------------------------------------------------------------------


        // ------------------------------------- *jobsheet 05* -------------------------------------
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list'  => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar Supplier yang terdaftar dalam sistem'
        ];

        $activeMenu = 'supplier';   //set menu yang sedang aktif

        return view(
            'supplier.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                ]
        );
    }

    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat', 'supplier_no_hp');

        return DataTables::of($suppliers)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($supplier) {
                $btn  = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    public function create_ajax() {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode',     //supplier_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_supplier kolom supplier_kode
                'supplier_nama'     => 'required|string|max:100',   //supplier_nama harus diisi, berupa string, maks 100 karakter
                'supplier_alamat'   => 'required|string|max:255',   //supplier_alamat harus diisi, berupa string, maks 255 karakter
                'supplier_no_hp'    => 'required|string|max:20'     //supplier_no_hp harus diisi, berupa string, maks 20 karakter
            ];

            $validator = Validator::make($request->all(), $rules);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            SupplierModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data Supplier berhasil disimpan'
            ]);
        }
    
        redirect('/');
    }   

    // JS6 - P2(edit_ajax)
    //menampilkan halaman form edit supplier ajax
    public function edit_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    // JS6 - P2(edit_ajax)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [ 
                'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',      
                'supplier_nama'     => 'required|string|max:100',   
                'supplier_alamat'   => 'required|string|max:255',
                'supplier_no_hp'    => 'required|string|max:20' 
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->update($request->all());
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
    $supplier = SupplierModel::find($id);

    return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    // JS6 - P3(hapus_ajax)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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
        $supplier = SupplierModel::find($id);

        return view('supplier.show_ajax', ['supplier' => $supplier]);
    }
}