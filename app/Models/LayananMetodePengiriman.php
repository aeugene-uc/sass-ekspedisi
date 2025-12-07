<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananMetodePengiriman extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'layanan_metode_pengiriman';

    protected $fillable = [
        'layanan_id',
        'metode_asal_pengiriman_id',
        'metode_destinasi_pengiriman_id',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function metodeAsal()
    {
        return $this->belongsTo(MetodeAsalPengiriman::class, 'metode_asal_pengiriman_id');
    }

    public function metodeDestinasi()
    {
        return $this->belongsTo(MetodeDestinasiPengiriman::class, 'metode_destinasi_pengiriman_id');
    }
}
