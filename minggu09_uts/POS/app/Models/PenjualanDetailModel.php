<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetailModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';
    // -----------------------------------------------------------------------------------------
    

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'penjualan_id', 
        'barang_id', 
        'harga', 
        'jumlah' 
    ];
}