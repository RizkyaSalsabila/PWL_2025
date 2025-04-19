<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;

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

// //route halaman HOME
// Route::get('/', function () {
//     // return view('welcome');
//     return view('home');
// });

// Route::get('/', function () {
//     // return view('welcome');
//     return view('home');
// });

// //route halaman PRODUCTS
// Route::prefix('category')->group(function() {
//     Route::get('/food-beverage', [ProductsController::class, 'foodBeverage']);
//     Route::get('/beauty-health', [ProductsController::class, 'beautyHealth']);
//     Route::get('/home-care', [ProductsController::class, 'homeCare']);
//     Route::get('/baby-kid', [ProductsController::class, 'babyKid']);
// });

// //route halaman USER
// Route::get('/user/{id}/name/{name}', [UserController::class, 'profile']);

// //route halaman PENJUALAN
// Route::get('sales', [SalesController::class, 'index']);


// JS3 - P4(DB_FACADES)
Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/barang', [BarangController::class, 'index']);
Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('/stok', [StokController::class, 'index']);
Route::get('/penjualan', [PenjualanController::class, 'index']);
Route::get('/penjualan_detail', [PenjualanDetailController::class, 'index']);
// -- ----------------------------------------------------------------------------------------- --

// -- ------------------------------------- *jobsheet 05* ------------------------------------- --
// -- JS5 - P2(5) --
Route::get('/', [WelcomeController::class, 'index']);
// -- ----------------------------------------------------------------------------------------- --

// -- ------------------------------------- *jobsheet 06* ------------------------------------- --
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);      //menampilkan halaman user
    Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatable
    
    // JS6 - P1(tambah_ajax)
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);     //menampilkan halaman form tambah user ajax
    Route::post('/ajax', [UserController::class, 'store_ajax']);            //menyimpan data user baru ajax
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);      //menampilkan halaman level
    Route::post('/list', [LevelController::class, 'list']);      //menampilkan data level dalam bentuk json untuk datatables

    // JS6 - P1(tambah_ajax)
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);     //menampilkan halaman form tambah level ajax
    Route::post('/ajax', [LevelController::class, 'store_ajax']);            //menyimpan data level baru ajax
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);      //menampilkan halaman kategori
    Route::post('/list', [KategoriController::class, 'list']);      //menampilkan data kategori dalam bentuk json untuk datatables

    // JS6 - P1(tambah_ajax)
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);     //menampilkan halaman form tambah kategori ajax
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);            //menyimpan data kategori baru ajax
});

Route::group(['prefix' => 'supplier'], function () {
    Route::get('/', [SupplierController::class, 'index']);      //menampilkan halaman supplier
    Route::post('/list', [SupplierController::class, 'list']);      //menampilkan data supplier dalam bentuk json untuk datatables

    // JS6 - P1(tambah_ajax)
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);     //menampilkan halaman form tambah supplier ajax
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);            //menyimpan data supplier baru ajax
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);      //menampilkan halaman barang
    Route::post('/list', [BarangController::class, 'list']);      //menampilkan data barang dalam bentuk json untuk datatables
 
    // JS6 - P1(tambah_ajax)
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);     //menampilkan halaman form tambah barang ajax
    Route::post('/ajax', [BarangController::class, 'store_ajax']);            //menyimpan data barang baru ajax
});

Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);      //menampilkan halaman stok
    Route::post('/list', [StokController::class, 'list']);      //menampilkan data stok dalam bentuk json untuk datatables
 
    // JS6 - P1(tambah_ajax)
    Route::get('/create_ajax', [StokController::class, 'create_ajax']);     //menampilkan halaman form tambah stok ajax
    Route::post('/ajax', [StokController::class, 'store_ajax']);            //menyimpan data stok baru ajax
});