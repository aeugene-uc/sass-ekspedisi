<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeranUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'is_platform_admin',
        'perusahaan_id',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'peran_id');
    }

    public function otorisasi()
    {
        return $this->belongsToMany(Otorisasi::class, 'peran_user_otorisasi', 'peran_id', 'otorisasi_id');
    }
}
