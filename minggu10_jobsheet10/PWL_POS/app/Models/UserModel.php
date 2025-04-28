<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel extends Authenticatable implements JWTSubject
// class UserModel extends Model
{
    // ------------------------------------- *jobsheet 10* -------------------------------------
    // JS10 - P1(Restful API Register)
    public function getJWTIdentifier() {     //untuk memberikan JWT id unik user
        return $this->getKey();             
    }

    public function getJWTCustomClaims() {  //untuk memberikan tambahan data ke token JWT
        return [];                          //[] berarti tidak ada tambahan data
    }

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
        'password',
        'profile_photo',
        'created_at',
        'updated_at'  
    ];

    // JS7 - P1(authentication)
    protected $hidden = ['password'];   //jangan ditampilkan saat select
    protected $casts = ['password' => 'hashed'];  //casting password agar otomatis di hash 

    // JS7 - P2(authorization)
    //untuk mendapatkan nama role
    public function getRoleName(): string {
        return $this->level->level_nama;
    }

    // JS7 - P2(authorization)
    //untuk mengecek apakah user memiliki role tertentu
    public function hasRole($role): bool {
        return $this->level->level_kode == $role;
    }

    // JS7 - P3(multi level-authorization)
    //untuk mendapatkan kode role
    public function getRole() {
        return $this->level->level_kode;
    }

    // JS4 - 2(Relationship)
    public function level(): BelongsTo {        //model ini memiliki relasi "dimiliki oleh" (belongsTo) dengan LevelModel
        return $this->belongsTo(
            LevelModel::class, 
            'level_id',         //PARAMETER 1 - foreign key di tabel model saat ini
            'level_id'          //PARAMETER 2 - primary key di tabel level_models yang menjadi referensi
        );      
    }

    public function stok(): HasMany {
        return $this->hasMany(StokModel::class, 'user_id', 'user_id');
    }

    public function penjualan(): HasMany {
        return $this->hasMany(PenjualanModel::class, 'user_id', 'user_id');
    }
}