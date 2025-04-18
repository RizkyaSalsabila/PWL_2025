<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data = [
            'kategori_kode' => 'KT06',
            'kategori_nama' => 'Perawatan',
            'deskripsi' => 'Kategori untuk produk-produk perawatan tubuh dan kecantikan'
        ];

        KategoriModel::create($data);

        //mencoba akses model BarangModel
        $kategori = KategoriModel::all();       //ambil semua data dari tabel 'm_kategori'
        return view('kategori', ['data' => $kategori]);
    }
}