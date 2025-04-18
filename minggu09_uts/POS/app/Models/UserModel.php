<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModel extends Model
{
    use HasFactory;
    // ------------------------------------- *jobsheet 03* -------------------------------------
    // JS3 - P6(Eloquent ORM)
    protected $table = 'm_user';    //mendefinisikan nama tabel yang digunakan di model ini
    protected $primaryKey = 'user_id';  //mendefinisikan primary key dari tabel yang digunakan
    // -----------------------------------------------------------------------------------------


    // ------------------------------------- *jobsheet 04* -------------------------------------
    //menyetting kolom agar bisa diisi ketika insert/update data
    protected $fillable = [
        'level_id', 
        'username',
        'nama',
        'password'     
    ];
}