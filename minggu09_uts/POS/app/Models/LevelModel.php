<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    // -----------------------------------------------------------------------------------------
    

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'level_kode', 
        'level_nama',
    ];

    // JS4 - 2(Relationship)
    public function user(): HasMany {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}