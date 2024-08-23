<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function jabatan(){
        return $this->hasOne(jabatan::class, 'id', 'id_jabatan');
    }

    public function pangkat(){
        return $this->hasOne(pangkat::class, 'id', 'id_pangkat');
    }

    public function detail(){
        return $this->belongsTo(detail::class);
    }

    public function pengaduan(){
        return $this->belongsTo(pengaduan_masyarakat::class);
    }

    public function keterangan(){
        return $this->hasMany(keterangan::class);
    }

    public function detail_regu(){
        return $this->hasMany(detail_regu::class, 'id_pegawai', 'id');
    }

    public function lokasi(){
        return $this->hasMany(lokasi::class, 'id_pegawai', 'id');
    }
}
