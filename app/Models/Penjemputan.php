<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjemputan extends Model
{
    protected $table = 'penjemputan';

    public $timestamps = false;

    protected $fillable = [
        'tanggal_penjemputan',
        'tanggal_selesai',
        'counter_destinasi_id',
        'kendaraan_id'
    ];

    public function counter()
    {
        return $this->belongsTo(Counter::class, 'counter_destinasi_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function kurir()
    {
        return $this->belongsToMany(User::class, 'kurir_penjemputan', 'penjemputan_id', 'kurir_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
