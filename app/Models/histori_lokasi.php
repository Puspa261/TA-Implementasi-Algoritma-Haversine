<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class histori_lokasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pegawai()
    {
        return $this->hasMany(User::class, 'id', 'id_pegawai');
    }
}
