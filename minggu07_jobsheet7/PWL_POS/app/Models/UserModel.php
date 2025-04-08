<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;     //JS7 - implementasi class Authenticatable

// ------------------------------------- *jobsheet 07* -------------------------------------
class UserModel extends Authenticatable 
// class UserModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 'm_user';    //mendefinisikan nama tabel yang digunakan di model ini
    protected $primaryKey = 'user_id';  //mendefinisikan primary key dari tabel yang digunakan
    // -----------------------------------------------------------------------------------------

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting agar bisa diisi ketika insert/update data
    // protected $fillable = [
    //     'level_id',
    //     'username', 
    //     'nama',
    //     'password'
    // ];

    //menyetting 3 kolom agar bisa diisi ketika insert/update data
    // protected $fillable = [
    //     'level_id', 
    //     'username',
    //     'nama',
    //     'password'      //^^sebagai solusi
    // ];
    // -----------------------------------------------------------------------------------------

    // -- JS7 - P1(2) --
    protected $fillable = [
        'username', 
        'password',
        'nama', 
        'level_id',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password'];   //jangan ditampilkan saat select
    protected $casts = ['password' => 'hashed'];  //casting password agar otomatis di hash 

    //PRAKTIKUM 2.7(1) - SOAL 1
    public function level(): BelongsTo {        //model ini memiliki relasi "dimiliki oleh" (belongsTo) dengan LevelModel
        return $this->belongsTo(
            LevelModel::class, 
            'level_id',         //PARAMETER 1 - foreign key di tabel model saat ini
            'level_id'          //PARAMETER 2 - primary key di tabel level_models yang menjadi referensi
        );      
    }
}