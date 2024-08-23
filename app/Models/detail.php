<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class detail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // public function surat_tugas(){
    //     return $this->hasMany(surat_tugas::class, 'id', 'id_surat_tugas');
    // }

    public function surat_tugas(){
        return $this->belongsTo(surat_tugas::class,'id_surat_tugas','id');
    }

    public function regu(){
        return $this->hasOne(regu::class, 'id', 'id_regu');
    }

}
