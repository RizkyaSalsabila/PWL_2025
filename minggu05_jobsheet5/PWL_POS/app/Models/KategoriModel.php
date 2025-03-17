<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriModel extends Model
{
    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --
    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';

    protected $fillable = ['kode_kategori', 'nama_kategori'];

    public function barang(): HasMany {
        return $this->hasMany(BarangModel::class, 'barang_id', 'barang_id');
    }
}