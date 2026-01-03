<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    protected $table = 'penjemputan';

    protected $fillable = [
        'tanggal_penjemputan',
        'tanggal_selesai',
        'kendaraan_id'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function kurir()
    {
        return $this->belongsToMany(User::class, 'kurir_penjemputan', 'penjemputan_id', 'kurir_id');
    }
}
