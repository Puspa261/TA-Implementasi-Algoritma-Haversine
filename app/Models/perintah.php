<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perintah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function surat_tugas(){
        return $this->hasOne(surat_tugas::class, 'id', 'id_surat_tugas');
    }

    public function regu(){
        return $this->hasOne(regu::class, 'id', 'id_regu');
    }
}
