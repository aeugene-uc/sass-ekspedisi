<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarMuat extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_dibuat',
        'tanggal_selesai',
        'counter_asal_id',
        'kendaraan_id',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function counter()
    {
        return $this->belongsTo(Counter::class, 'counter_asal_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function kurir()
    {
        return $this->belongsToMany(User::class, 'kurir_daftar_muat', 'daftar_muat_id', 'kurir_id');
    }
}
