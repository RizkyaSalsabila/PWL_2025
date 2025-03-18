<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    // public function index(){
    //   //Menambahkan 1 data ke 'm_kategori'
    //    /*data = [
    //         'kode_kategori' => 'SNK',
    //         'nama_kategori' => 'Snack/Makanan Ringan',
    //         'created_at' => now()
    //     ];

    //     DB::table('m_kategori')->insert($data);
    //     return 'Insert data baru berhasil';*/

    //     //Mengupdate data di 'm_kategori'
    //    /*row = DB::table('m_kategori')->where('kode_kategori', 'SNK')->update(['nama_kategori' => 'Camilan']);
    //     return 'Update data berhasil, jumlah data yang diupdate: '.$row. ' baris';*/

    //     //Menghapus data yang sudah ada di 'm_kategori'
    //    /*row = DB::table('m_kategori')->where('kode_kategori', 'SNK')->delete();
    //     return 'Delete data berhasil, jumlah data yang dihapus: '.$row. ' baris';*/

    //     //Menampilkan data di 'm_kategori'
    //     $data = DB::table('m_kategori')->get();
    //     return view('kategori', ['data' => $data]);

    // }
    // -- ----------------------------------------------------------------------------------------- --

    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    public function index(KategoriDataTable $dataTable) {
        return $dataTable->render('kategori.index');
    }

    public function create() {
        return view('kategori.create');
    }

    public function store(Request $request) {
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'nama_kategori' => $request->namaKategori,
        ]);

        return redirect('/kategori');
    }
}