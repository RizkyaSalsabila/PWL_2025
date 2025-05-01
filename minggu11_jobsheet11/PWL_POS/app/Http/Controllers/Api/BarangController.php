<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        // $barang = BarangModel::create($request->all());

        // JS11 - Tugas(Eloquent Accessor) 
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode', 
            'barang_nama' => 'required|string|max:100', 
            'harga_beli'  => 'required|integer',
            'harga_jual'  => 'required|integer',
            'kategori_id' => 'required',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //if validations fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image');

        //create barang
        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode, 
            'barang_nama' => $request->barang_nama, 
            'harga_beli'  => $request->harga_beli,
            'harga_jual'  => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
            'image'       => $image->hashName(),
        ]);

        // return response()->json($barang, 201);

        //return response JSON barang is created
        if ($barang) {
            return response()->json([
                'success'   => true,
                'barang'      => $barang,
            ], 201);
        }
         //return JSON process insert failed
         return response()->json([
            'success'   => false,
        ], 409);
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