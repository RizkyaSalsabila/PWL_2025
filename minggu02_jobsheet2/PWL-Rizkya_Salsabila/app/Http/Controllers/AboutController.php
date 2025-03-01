<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// AboutController mewarisi fungsi dari class Controller
class AboutController extends Controller
{
    public function about() {       // method 'about' dengan modifier public
        return '2341720056 - Rizkya Salsabila';     // mengembalikan 'NIM - Nama'
    }
}