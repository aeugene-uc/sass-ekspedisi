<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKendaraan extends Model
{
    public $table = 'jenis_kendaraan';

    public $timestamps = false;

    protected $fillable = [
        'jenis',
    ];
}
