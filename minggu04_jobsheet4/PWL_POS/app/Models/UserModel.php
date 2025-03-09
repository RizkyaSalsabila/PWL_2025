<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    // ------------------------------------- *jobsheet 03* -------------------------------------
    protected $table = 'm_user';    //mendefinisikan nama tabel yang digunakan di model ini
    protected $primaryKey = 'user_id';  //mendefinisikan primary key dari tabel yang digunakan
    // -----------------------------------------------------------------------------------------

    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting agar bisa diisi ketika insert/update data
    protected $fillable = [
        'level_id',
        'username', 
        'nama',
        'password'
    ];
}