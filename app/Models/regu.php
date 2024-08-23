<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class regu extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail_regu(){
        return $this->hasMany(detail_regu::class, 'id_regu', 'id');
    }
}
