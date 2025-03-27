<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);

//PRAKTIKUM 2.6(2) - SOAL 5
Route::get('/user/tambah', [UserController::class, 'tambah']);

//PRAKTIKUM 2.6(3) - SOAL 8
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

//PRAKTIKUM 2.6(4) - SOAL 12
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);

//PRAKTIKUM 2.6(5) - SOAL 15
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

//PRAKTIKUM 2.6(6) - SOAL 18
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);


// -- ------------------------------------- *jobsheet 05* ------------------------------------- --
// -- JS5 - P2(5) --
Route::get('/', [WelcomeController::class, 'index']);

// -- JS5 - P3(3) --
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);      //menampilkan halaman user
    Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
    Route::get('/create', [UserController::class, 'create']);      //menampilkan halaman form tambah user
    Route::post('/', [UserController::class, 'store']);      //menyimpan data user baru
    Route::get('/{id}', [UserController::class, 'show']);      //P3(13) - menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);      //P3(17) - menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);      //P3(17) - menyimpan perubahan data user
    Route::delete('/{id}', [UserController::class, 'destroy']);      //P3(21) - menghapus data user
});

// -- JS5 - Tugas(m_level) --
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);      //menampilkan halaman level
    Route::post('/list', [LevelController::class, 'list']);      //menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);      //menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);      //menyimpan data level baru
    Route::get('/{id}', [LevelController::class, 'show']);      //menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);      //menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);      //menyimpan perubahan data level
    Route::delete('/{id}', [LevelController::class, 'destroy']);      //menghapus data level
});

// -- JS5 - Tugas(m_kategori) --
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);      //menampilkan halaman kategori
    Route::post('/list', [KategoriController::class, 'list']);      //menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);      //menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);      //menyimpan data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']);      //menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);      //menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);      //menyimpan perubahan data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);      //menghapus data kategori
});