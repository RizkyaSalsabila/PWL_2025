<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //PRAKTIKUM 2.7(1) - TAMBAHAN
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    // -----------------------------------------------------------------------------------------

    
    // ------------------------------------- *jobsheet 05* -------------------------------------
    // JS5 - Tugas(m_level)
    //menyetting 2 kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    public function user(): HasMany {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}