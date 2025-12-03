<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat_nomor',
        'operasional',
        'jenis_kendaraan_id',
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisKendaraan::class, 'jenis_kendaraan_id');
    }

    public function daftarMuat()
    {
        return $this->hasMany(DaftarMuat::class);
    }
}
