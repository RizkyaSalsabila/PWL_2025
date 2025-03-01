<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// HomeController mewarisi fungsi dari class Controller
class HomeController extends Controller
{
    public function index() {       // method 'index' dengan modifier public
        return 'Selamat Datang';    // mengembalikan 'Selamat Datang'
    }
}