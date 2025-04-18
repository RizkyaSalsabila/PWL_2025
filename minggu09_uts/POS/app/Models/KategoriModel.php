<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    // JS4 - 2(Relationship)
    public function barang(): HasMany {
        return $this->hasMany(BarangModel::class, 'kategori_id', 'kategori_id');
    }
}