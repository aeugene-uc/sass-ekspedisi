<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisKendaraan extends Model
{
    use HasFactory;

    protected $fillable = ['jenis'];

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class);
    }
}
