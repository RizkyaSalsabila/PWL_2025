<?php

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

Route::get('/', function () {
    return view('welcome');
});

// -- ------------------------------------- *jobsheet 04* ------------------------------------- --
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
// -- ----------------------------------------------------------------------------------------- --


// -- ------------------------------------- *jobsheet 05* ------------------------------------- --
// Route::get('/kategori/create', [KategoriController::class, 'create']);
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');

//TUGAS(1)
Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');

//TUGAS(3)
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');

//TUGAS(4)
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');