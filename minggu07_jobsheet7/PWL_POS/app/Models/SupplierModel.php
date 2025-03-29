<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    use HasFactory;
    // ------------------------------------- *jobsheet 05* -------------------------------------
    // JS5 - Tugas(m_supplier)
    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';

    //menyetting 3 kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat'
    ];

    public function stok(): HasMany {
        return $this->hasMany(StokModel::class, 'supplier_id', 'supplier_id');
    }
}