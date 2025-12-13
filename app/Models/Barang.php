<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'barang';

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
