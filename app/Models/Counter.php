<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counter extends Model
{
    use HasFactory;

    protected $fillable = [
        'perusahaan_id',
        'alamat',
        'lat',
        'lng',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function daftarMuat()
    {
        return $this->hasMany(DaftarMuat::class, 'counter_asal_id');
    }
}
