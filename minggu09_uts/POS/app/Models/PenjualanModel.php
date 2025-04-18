<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjualanModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 't_penjualan';
    protected $primaryKey = 'penjualan_id';
    // -----------------------------------------------------------------------------------------
    

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'user_id', 
        'pembeli', 
        'penjualan_kode', 
        'penjualan_tanggal'   
    ];

    // JS4 - 2(Relationship)
    public function penjualan_detail(): HasMany {
        return $this->hasMany(PenjualanDetailModel::class, 'penjualan_id', 'penjualan_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id', 'user_id');
    }
}