<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'layanan';

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

    public function metodePengiriman()
    {
        return $this->hasMany(LayananMetodePengiriman::class);
    }
}
