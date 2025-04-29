<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // ------------------------------------- *jobsheet 10* -------------------------------------
    // JS10 - Tugas(CRUD Restful API - kategori)

    // menampilkan semua data kategori
    public function index() {
        return KategoriModel::all();
    }

    // menyimpan data kategori baru ke database
    public function store(Request $request) {
        $kategori = KategoriModel::create($request->all());
        return response()->json($kategori, 201);
    }

    // menampilkan detail data kategori berdasarkan id
    public function show(KategoriModel $kategori) {
        return KategoriModel::find($kategori);
    }

    // memperbarui data kategori berdasarkan id
    public function update(Request $request, KategoriModel $kategori) {
        $kategori->update($request->all());
        return KategoriModel::find($kategori);
    }

    // menghapus data kategori berdasarkan id
    public function destroy(KategoriModel $kategori) {
        $kategori->delete();

        return response()->json([
            'succes'    => true,
            'message'   => 'Data berhasil terhapus',
        ]);
    }
}