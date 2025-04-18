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
