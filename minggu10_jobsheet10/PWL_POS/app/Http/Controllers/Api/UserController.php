<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
        // ------------------------------------- *jobsheet 10* -------------------------------------
    // JS10 - Tugas(CRUD Restful API - user)

    // menampilkan semua data user
    public function index() {
        return UserModel::all();
    }

    // menyimpan data user baru ke database
    public function store(Request $request) {
        $user = UserModel::create($request->all());
        return response()->json($user, 201);
    }

    // menampilkan detail data user berdasarkan id
    public function show(UserModel $user) {
        return UserModel::find($user);
    }

    // memperbarui data user berdasarkan id
    public function update(Request $request, UserModel $user) {
        $user->update($request->all());
        return UserModel::find($user);
    }

    // menghapus data user berdasarkan id
    public function destroy(UserModel $user) {
        $user->delete();

        return response()->json([
            'succes'    => true,
            'message'   => 'Data berhasil terhapus',
        ]);
    }
}