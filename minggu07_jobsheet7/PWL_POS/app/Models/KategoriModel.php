<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;
    // ------------------------------------- *jobsheet 05* -------------------------------------
    // JS5 - Tugas(m_level)
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';

    //menyetting 2 kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi'
    ];

    public function barang(): HasMany {
        return $this->hasMany(BarangModel::class, 'kategori_id', 'kategori_id');
    }
}