<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// ArticleController mewarisi fungsi dari class Controller
class ArticleController extends Controller
{
    public function articles($id) { // method 'articles' dengan modifier public yang memiliki 1 parameter 'id'
        return 'Halaman Artikel dengan Id ' .$id;       // mengembalikan 'kalimat tersebut disertai dengan id yang dinamis '
    }
}