<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodeDestinasiPengiriman extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'metode_destinasi_pengiriman_id');
    }
}
