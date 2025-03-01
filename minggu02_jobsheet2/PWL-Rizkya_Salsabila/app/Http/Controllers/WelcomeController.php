<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// WelcomeController mewarisi fungsi dari class Controller
class WelcomeController extends Controller
{
    public function hello() {   // method 'hello' dengan modifier public
        return 'Hello World';   // mengembalikan 'Hello World'
    }

    // public function greeting () { 
    //     return view('blog.hello', ['name' => 'Rizkya']);
    // }

    public function greeting () {   // method 'greeting' dengan modifier public
        return view('blog.hello')   // mengembalikan view pada 'blog.hello'
        ->with('name', 'Rizkya')    // mengembalikan nama 'Rizkya'
        ->with('occupation', 'Astronaut');  //mengembalikan pekerjaan 'Astronaut'
    }
}