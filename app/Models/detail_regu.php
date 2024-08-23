<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_regu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function regu(){
        return $this->hasOne(regu::class, 'id', 'id_regu');
    }

    public function user(){
        return $this->hasMany(User::class, 'id', 'id_pegawai');
    }

    public function jabatan_tugas(){
        return $this->hasMany(jabatan_tugas::class, 'id', 'id_jabatan_tugas');
    }
}
