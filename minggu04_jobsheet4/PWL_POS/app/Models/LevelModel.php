<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //PRAKTIKUM 2.7(1) - TAMBAHAN
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
}