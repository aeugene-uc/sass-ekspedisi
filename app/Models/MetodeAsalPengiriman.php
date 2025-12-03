<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetodeAsalPengiriman extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'metode_asal_pengiriman_id');
    }
}
