<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
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
    
    // -- JS6 - P1(6) --
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);     //menampilkan halaman form tambah user ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);            //menyimpan data user baru ajax

    Route::get('/{id}', [UserController::class, 'show']);      //P3(13) - menampilkan detail user
    Route::get('/{id}/edit', [UserController::class, 'edit']);      //P3(17) - menampilkan halaman form edit user
    Route::put('/{id}', [UserController::class, 'update']);      //P3(17) - menyimpan perubahan data user
   
    // -- JS6 - P2(3) --
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);    //menampilkan halaman form edit user ajax
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);    //menyimpan perubahan data user ajax

    // -- JS6 - P3(2) --
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);       //menampilkan form confirm delete user ajax
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);     //menghapus data user ajax

    Route::delete('/{id}', [UserController::class, 'destroy']);      //P3(21) - menghapus data user
});

// -- JS5 - Tugas(m_level) --
Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);      //menampilkan halaman level
    Route::post('/list', [LevelController::class, 'list']);      //menampilkan data level dalam bentuk json untuk datatables
    Route::get('/create', [LevelController::class, 'create']);      //menampilkan halaman form tambah level
    Route::post('/', [LevelController::class, 'store']);      //menyimpan data level baru

    // -- JS6 - Tugas(m_level) --
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);     //menampilkan halaman form tambah level ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']);            //menyimpan data level baru ajax

    Route::get('/{id}', [LevelController::class, 'show']);      //menampilkan detail level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);      //menampilkan halaman form edit level
    Route::put('/{id}', [LevelController::class, 'update']);      //menyimpan perubahan data level

    // -- JS6 - Tugas(m_level) --
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);    //menampilkan halaman form edit level ajax
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);    //menyimpan perubahan data level ajax

    // -- JS6 - Tugas(m_level) --
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);       //menampilkan form confirm delete level ajax
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);     //menghapus data level ajax

    Route::delete('/{id}', [LevelController::class, 'destroy']);      //menghapus data level
});

// -- JS5 - Tugas(m_kategori) --
Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);      //menampilkan halaman kategori
    Route::post('/list', [KategoriController::class, 'list']);      //menampilkan data kategori dalam bentuk json untuk datatables
    Route::get('/create', [KategoriController::class, 'create']);      //menampilkan halaman form tambah kategori
    Route::post('/', [KategoriController::class, 'store']);      //menyimpan data kategori baru

    // -- JS6 - Tugas(m_kategori) --
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);     //menampilkan halaman form tambah kategori ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);            //menyimpan data kategori baru ajax
    
    Route::get('/{id}', [KategoriController::class, 'show']);      //menampilkan detail kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);      //menampilkan halaman form edit kategori
    Route::put('/{id}', [KategoriController::class, 'update']);      //menyimpan perubahan data kategori

    // -- JS6 - Tugas(m_kategori) --
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);    //menampilkan halaman form edit kategori ajax
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);    //menyimpan perubahan data kategori ajax

    Route::delete('/{id}', [KategoriController::class, 'destroy']);      //menghapus data kategori

    // -- JS6 - Tugas(m_kategori) --
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);       //menampilkan form confirm delete kategori ajax
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);     //menghapus data kategori ajax
});

// -- JS5 - Tugas(m_supplier) --
Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);      //menampilkan halaman supplier
    Route::post('/list', [SupplierController::class, 'list']);      //menampilkan data supplier dalam bentuk json untuk datatables
    Route::get('/create', [SupplierController::class, 'create']);      //menampilkan halaman form tambah supplier
    Route::post('/', [SupplierController::class, 'store']);      //menyimpan data supplier baru

    // -- JS6 - Tugas(m_supplier) --
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);     //menampilkan halaman form tambah supplier ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);            //menyimpan data supplier baru ajax

    Route::get('/{id}', [SupplierController::class, 'show']);      //menampilkan detail supplier
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);      //menampilkan halaman form edit supplier
    Route::put('/{id}', [SupplierController::class, 'update']);      //menyimpan perubahan data supplier

    // -- JS6 - Tugas(m_supplier) --
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);    //menampilkan halaman form edit supplier ajax
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);    //menyimpan perubahan data supplier ajax

    Route::delete('/{id}', [SupplierController::class, 'destroy']);      //menghapus data supplier

    // -- JS6 - Tugas(m_supplier) --
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);       //menampilkan form confirm delete supplier ajax
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);     //menghapus data supplier ajax
});

// -- JS5 - Tugas(m_barang) --
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);      //menampilkan halaman barang
    Route::post('/list', [BarangController::class, 'list']);      //menampilkan data barang dalam bentuk json untuk datatables
    Route::get('/create', [BarangController::class, 'create']);      //menampilkan halaman form tambah barang
    Route::post('/', [BarangController::class, 'store']);      //menyimpan data barang baru
    Route::get('/{id}', [BarangController::class, 'show']);      //menampilkan detail barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']);      //menampilkan halaman form edit barang
    Route::put('/{id}', [BarangController::class, 'update']);      //menyimpan perubahan data barang
    Route::delete('/{id}', [BarangController::class, 'destroy']);      //menghapus data barang
});