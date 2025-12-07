<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodeAsalPengiriman extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nama'];

    public function layanan()
    {
        return $this->hasMany(LayananMetodePengiriman::class, 'metode_asal_pengiriman_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'metode_asal_pengiriman_id');
    }
}
