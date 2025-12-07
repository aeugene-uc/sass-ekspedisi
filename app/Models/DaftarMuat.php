<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarMuat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tanggal_dibuat',
        'tanggal_selesai',
        'counter_asal_id',
        'kendaraan_id',
    ];

    public function counter()
    {
        return $this->belongsTo(Counter::class, 'counter_asal_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function kurirs()
    {
        return $this->belongsToMany(User::class, 'kurir_daftar_muat', 'daftar_muat_id', 'kurir_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
