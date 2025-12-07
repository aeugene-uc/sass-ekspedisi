<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['perusahaan_id', 'alamat', 'lat', 'lng'];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function daftarMuat()
    {
        return $this->hasMany(DaftarMuat::class, 'counter_asal_id');
    }
}
