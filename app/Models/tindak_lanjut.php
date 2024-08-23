<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tindak_lanjut extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function pengaduan(){
        return $this->hasOne(pengaduan_masyarakat::class, 'id', 'id_pengaduan');
    }
}
