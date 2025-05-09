<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    // public function index()
    // {
    //     //KODE AWAL
    //     // DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
    //     // return 'Insert data baru berhasil';

    //     //KODE KEDUA
    //     // $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']); 
    //     // return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';

    //     //KODE KETIGA
    //     // $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']); // Menghapus data dengan kode = 'CUS'
    //     // return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';

    //     //KODE BARU
    //     $data = DB::select('select * from m_level'); // Menampilkan semua data dari tabel 'm_level'
    //     return view('level', ['data' => $data]);
    // }


    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    // JS5 - Tugas(m_level)
    //menampilkan halaman awal level 
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list'  => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level';   //set menu yang sedang aktif

        $level = LevelModel::all();     //ambil data level untuk filter level

        return view(
            'level.index', 
            [
                'breadcrumb' => $breadcrumb, 
                'page' => $page, 
                'activeMenu' => $activeMenu,
                'level' => $level
                ]
        );
    }

    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // menambahkan kolom aksi
            ->addColumn('aksi', function ($level) {
                $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a>';
                $btn .= ' <a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= ' <form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\')">Hapus</button>'
                    . '</form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //menampilkan halaman form tambah level
    public function create() {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list'  => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level Baru'
        ];

        $activeMenu = 'user';           //set menu yang sedang aktif

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    //menyimpan data level baru
    public function store(Request $request) {
        $request->validate([
            'level_kode'  => 'required|string|max:8|unique:m_level,level_kode',     //level_kode harus diisi, berupa string, maks 8 karakter, bernilai unik di tabel m_level kolom level_kode
            'level_nama'  => 'required|string|max:100',   //level_nama harus diisi, berupa string, maks 100 karakter
        ]);

        LevelModel::create([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil disimpan');
    }  
 
    //menampilkan detail level
    public function show(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list'  => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];

        $activeMenu = 'level';       //set menu yang sedang aktif

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //menampilkan halaman form edit level
    public function edit(string $id) {
        $level = LevelModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list'  => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Level'
        ];

        $activeMenu = 'level';       //set menu yang sedang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //menyimpan perubahan data level 
    public function update(Request $request, string $id) {
        $request->validate([
            'level_kode'  => 'required|string|max:8|unique:m_level,level_kode,'.$id.',level_id',    //level_kode harus diisi, berupa string, maks 8 karakter, bernilai unik di tabel m_level kolom level_kode
            'level_nama'  => 'required|string|max:100',   //level_nama harus diisi, berupa string, maks 100 karakter
        ]);

        LevelModel::find($id)->update([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil diubah');
    } 

    //menghapus data level
    public function destroy(string $id) {
        $check = LevelModel::find($id);
        if (!$check) {  //untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
            return redirect('/level')->with('error', 'Data Level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);    //Hapus data level

            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            
            //jika terjadi error ketika menghapus data,
            //redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}