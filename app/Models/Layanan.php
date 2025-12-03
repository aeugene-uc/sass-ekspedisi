<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'gambar',
        'model_harga',
        'perusahaan_id',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function jangkauan()
    {
        return $this->belongsToMany(Jangkauan::class, 'layanan_jangkauan', 'layanan_id', 'jangkauan_id');
    }

    public function metodePengiriman()
    {
        return $this->belongsToMany(
            MetodeAsalPengiriman::class,
            'layanan_metode_pengiriman',
            'layanan_id',
            'metode_asal_pengiriman_id'
        )->withPivot('metode_destinasi_pengiriman_id');
    }
}
