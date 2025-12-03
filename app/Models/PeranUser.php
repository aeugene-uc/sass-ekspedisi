<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeranUser extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'perusahaan_id'];

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
        return $this->belongsToMany(Otorisasi::class, 'peranuser_otorisasi', 'peran_id', 'otorisasi_id');
    }
}
