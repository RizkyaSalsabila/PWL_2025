<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;
    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';
    // -----------------------------------------------------------------------------------------
    

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'kategori_kode', 
        'kategori_nama',
        'deskripsi',    
    ];
}