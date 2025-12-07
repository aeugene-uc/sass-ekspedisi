<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tarif',
        'tanggal_pemesanan',
        'tanggal_terkirim',
        'foto_terkirim',
        'daftar_muat_id',
        'user_id',
        'metode_destinasi_pengiriman_id',
        'metode_asal_pengiriman_id',
        'lat_asal',
        'lng_asal',
        'alamat_asal',
        'lat_destinasi',
        'lng_destinasi',
        'alamat_destinasi',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function daftarMuat()
    {
        return $this->belongsTo(DaftarMuat::class);
    }

    public function status()
    {
        return $this->belongsTo(StatusPesanan::class, 'status_id');
    }

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public function bukuKasus()
    {
        return $this->hasMany(BukuKasus::class);
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
