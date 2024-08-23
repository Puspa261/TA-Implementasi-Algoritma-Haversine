<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class surat_tugas extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasOne(detail::class, 'id_surat_tugas', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pegawai', 'id');
    }


}
