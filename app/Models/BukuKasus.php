<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKasus extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'buku_kasus';

    protected $fillable = [
        'pesanan_id',
        'kasus',
        'foto',
        'tanggal_dibuat',
        'tanggal_selesai',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
