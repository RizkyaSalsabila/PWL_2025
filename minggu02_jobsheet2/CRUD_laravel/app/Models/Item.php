<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    //mengizinkan atribut berikut untuk mass assignment
    protected $fillable = ['name', 'description', 'stock', 'price'];    //menambahkan kode ini karena laravel memiliki sistem keamanan untuk mencegah pengguna tidak sah memasukkan data yang tidak diizinkan
}