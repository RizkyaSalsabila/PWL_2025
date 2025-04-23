<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';
    // -----------------------------------------------------------------------------------------
    

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'supplier_kode', 
        'supplier_nama',
        'supplier_alamat',    
        'supplier_no_hp'
    ];

    // JS4 - 2(Relationship)
    public function stok(): HasMany {
        return $this->hasMany(StokModel::class, 'supplier_id', 'supplier_id');
    }
}