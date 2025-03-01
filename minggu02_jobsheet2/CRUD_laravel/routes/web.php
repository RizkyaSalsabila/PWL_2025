<?php

use App\Http\Controllers\ItemController;
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

Route::get('/', function () {       //menampilkan halaman utama
    return view('welcome');         //yakni 'welcome'
});

Route::resource('items', ItemController::class);        //membuat rute otomatis untuk CRUD berdasarkan 'ItemController'