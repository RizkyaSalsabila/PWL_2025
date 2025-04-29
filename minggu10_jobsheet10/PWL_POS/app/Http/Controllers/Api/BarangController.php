<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // ------------------------------------- *jobsheet 10* -------------------------------------
    // JS10 - Tugas(CRUD Restful API - barang)

    // menampilkan semua data barang
    public function index() {
        return BarangModel::all();
    }

    // menyimpan data barang baru ke database
    public function store(Request $request) {
        $barang = BarangModel::create($request->all());
        return response()->json($barang, 201);
    }

    // menampilkan detail data barang berdasarkan id
    public function show(BarangModel $barang) {
        return BarangModel::find($barang);
    }

    // memperbarui data barang berdasarkan id
    public function update(Request $request, BarangModel $barang) {
        $barang->update($request->all());
        return BarangModel::find($barang);
    }

    // menghapus data barang berdasarkan id
    public function destroy(BarangModel $barang) {
        $barang->delete();

        return response()->json([
            'succes'    => true,
            'message'   => 'Data berhasil terhapus',
        ]);
    }
}