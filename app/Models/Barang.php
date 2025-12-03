<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'foto',
        'berat_g',
        'panjang_cm',
        'lebar_cm',
        'tinggi_cm',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
