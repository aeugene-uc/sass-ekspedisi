<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'peran_id',
        'perusahaan_id',
        'is_platform_admin'
        // add other FK fields here
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function peran()
    {
        return $this->belongsTo(PeranUser::class, 'peran_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function kurirDaftarMuat()
    {
        return $this->belongsToMany(DaftarMuat::class, 'kurir_daftar_muat', 'kurir_id', 'daftar_muat_id');
    }

}
