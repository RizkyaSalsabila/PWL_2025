<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    // public function index(){
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
    //     $data = DB::table('m_kategori')->get();
    //     return view('kategori', ['data' => $data]);

    // }


    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    // JS5 - Tugas(m_kategori)
    //menampilkan halaman awal kategori 
    public function index() {
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
        $kategoris = KategoriModel::select('kategori_id', 'kode_kategori', 'nama_kategori', 'deskripsi');

        return DataTables::of($kategoris)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($kategori) {
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a>';
                $btn .= ' <a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= ' <form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                    . '</form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //menampilkan halaman form tambah kategori
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list'  => ['Home', 'Kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kategori Baru'
        ];

        $activeMenu = 'kategori';           //set menu yang sedang aktif

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    //menyimpan data kategori baru
    public function store(Request $request) {
        $request->validate([
            'kode_kategori'  => 'required|string|max:8|unique:m_kategori,kode_kategori',     //kode_kategori harus diisi, berupa string, maks 8 karakter, bernilai unik di tabel m_level kolom level_kode
            'nama_kategori'  => 'required|string|max:100',   //nama_kategori harus diisi, berupa string, maks 100 karakter
            'deskripsi'      => 'required|string|max:200'
        ]);

        KategoriModel::create([
            'kode_kategori'  => $request->kode_kategori,
            'nama_kategori'  => $request->nama_kategori,
            'deskripsi'      => $request->deskripsi,
        ]);

        return redirect('/kategori')->with('success', 'Data Kategori berhasil disimpan');
    }  
 
    //menampilkan detail kategori
    public function show(string $id) {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list'  => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';       //set menu yang sedang aktif

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //menampilkan halaman form edit kategori
    public function edit(string $id) {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list'  => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Kategori'
        ];

        $activeMenu = 'kategori';       //set menu yang sedang aktif

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    //menyimpan perubahan data kategori 
    public function update(Request $request, string $id) {
        $request->validate([
            'kode_kategori'  => 'required|string|max:8|unique:m_kategori,kode_kategori,'.$id.',kategori_id',    
            'nama_kategori'  => 'required|string|max:100',   
            'deskripsi'      => 'required|string|max:200'
        ]);

        KategoriModel::find($id)->update([
            'kode_kategori'  => $request->kode_kategori,
            'nama_kategori'  => $request->nama_kategori,
            'deskripsi'      => $request->deskripsi,
        ]);

        return redirect('/kategori')->with('success', 'Data Kategori berhasil diubah');
    } 

    //menghapus data kategori
    public function destroy(string $id) {
        $check = KategoriModel::find($id);
        if (!$check) {  //untuk mengecek apakah data kategori dengan id yang dimaksud ada atau tidak
            return redirect('/kategori')->with('error', 'Data Kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);    //Hapus data kategori

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            //jika terjadi error ketika menghapus data,
            //redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}