<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LevelModel;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    // ------------------------------------- *jobsheet 10* -------------------------------------
    // JS10 - P4(CRUD Restful API - level)

    // menampilkan semua data level
    public function index() {
        return LevelModel::all();
    }

    // menyimpan data level baru ke database
    public function store(Request $request) {
        $level = LevelModel::create($request->all());
        return response()->json($level, 201);
    }

    // menampilkan detail data level berdasarkan id
    public function show(LevelModel $level) {
        return LevelModel::find($level);
    }

    // memperbarui data level berdasarkan id
    public function update(Request $request, LevelModel $level) {
        $level->update($request->all());
        return LevelModel::find($level);
    }

    // menghapus data level berdasarkan id
    public function destroy(LevelModel $level) {
        $level->delete();

        return response()->json([
            'succes'    => true,
            'message'   => 'Data berhasil terhapus',
        ]);
    }
}