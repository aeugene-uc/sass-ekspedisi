<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    public $table = 'kendaraan';

    public $timestamps = false;

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
