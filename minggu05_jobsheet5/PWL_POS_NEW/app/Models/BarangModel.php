<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangModel extends Model
{
    use HasFactory;
    // ------------------------------------- *jobsheet 05* -------------------------------------
    // JS5 - Tugas(m_barang)
    protected $table = 'm_barang';    //mendefinisikan nama tabel yang digunakan di model ini
    protected $primaryKey = 'barang_id';  //mendefinisikan primary key dari tabel yang digunakan

    //menyetting 5 kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'kategori_id',
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual'  
    ];

    //model ini memiliki relasi "dimiliki oleh" (belongsTo) dengan KategoriModel
    public function kategori(): BelongsTo {        
        return $this->belongsTo(
            KategoriModel::class, 
            'kategori_id',         //PARAMETER 1 - foreign key di tabel model saat ini
            'kategori_id'          //PARAMETER 2 - primary key di tabel kategori_models yang menjadi referensi
        );      
    }
}