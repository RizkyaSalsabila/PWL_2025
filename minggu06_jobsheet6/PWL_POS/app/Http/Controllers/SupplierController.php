<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    // JS5 - Tugas(m_supplier)
    //menampilkan halaman awal supplier 
    public function index() {
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
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        return DataTables::of($suppliers)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($supplier) {
                // $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // $btn .= ' <a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // $btn .= ' <form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
                //     . csrf_field()
                //     . method_field('DELETE')
                //     . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                //     . '</form>';

                // JS6 - Tugas(m_supplier) 
                $btn  = '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 

                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //menampilkan halaman form tambah supplier
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list'  => ['Home', 'Supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Supplier Baru'
        ];

        $activeMenu = 'supplier';           //set menu yang sedang aktif

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    //menyimpan data supplier baru
    public function store(Request $request) {
        $request->validate([
            'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode',     //supplier_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_supplier kolom supplier_kode
            'supplier_nama'     => 'required|string|max:100',   //supplier_nama harus diisi, berupa string, maks 100 karakter
            'supplier_alamat'   => 'required|string|max:255'     //supplier_alamat harus diisi, berupa string, maks 255 karakter
        ]);

        SupplierModel::create([
            'supplier_kode'    => $request->supplier_kode,
            'supplier_nama'    => $request->supplier_nama,
            'supplier_alamat'  => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data Supplier berhasil disimpan');
    }  
 
    //menampilkan detail supplier
    public function show(string $id) {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list'  => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Supplier'
        ];

        $activeMenu = 'supplier';       //set menu yang sedang aktif

        return view('supplier.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    //menampilkan halaman form edit supplier
    public function edit(string $id) {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list'  => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Supplier'
        ];

        $activeMenu = 'supplier';       //set menu yang sedang aktif

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    //menyimpan perubahan data supplier 
    public function update(Request $request, string $id) {
        $request->validate([  
            'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode,'.$id.',supplier_id',     
            'supplier_nama'     => 'required|string|max:100', 
            'supplier_alamat'   => 'required|string|max:255'     
        ]);

        SupplierModel::find($id)->update([
            'supplier_kode'     => $request->supplier_kode,
            'supplier_nama'     => $request->supplier_nama,
            'supplier_alamat'   => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data Supplier berhasil diubah');
    } 

    //menghapus data supplier
    public function destroy(string $id) {
        $check = SupplierModel::find($id);
        if (!$check) {  //untuk mengecek apakah data supplier dengan id yang dimaksud ada atau tidak
            return redirect('/supplier')->with('error', 'Data Supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);    //Hapus data supplier

            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            //jika terjadi error ketika menghapus data,
            //redirect kembali ke halaman dengan membawa pesan error
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }   
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 06* ------------------------------------- --
    // JS6 - Tugas(m_supplier)
    public function create_ajax() {
        return view('supplier.create_ajax');
    }

    // JS6 - Tugas(m_supplier)
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode',     //supplier_kode harus diisi, berupa string, maks 10 karakter, bernilai unik di tabel m_supplier kolom supplier_kode
                'supplier_nama'     => 'required|string|max:100',   //supplier_nama harus diisi, berupa string, maks 100 karakter
                'supplier_alamat'   => 'required|string|max:255'     //supplier_alamat harus diisi, berupa string, maks 255 karakter
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

    // JS6 - Tugas(m_supplier)
    //menampilkan halaman form edit supplier ajax
    public function edit_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    // JS6 - Tugas(m_supplier)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [ 
                'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',      
                'supplier_nama'     => 'required|string|max:100',   
                'supplier_alamat'   => 'required|string|max:255' 
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

    // JS6 - Tugas(m_supplier)
    public function confirm_ajax(string $id) {
        $supplier = SupplierModel::find($id);

        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
     }

    // JS6 - Tugas(m_supplier)
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
}