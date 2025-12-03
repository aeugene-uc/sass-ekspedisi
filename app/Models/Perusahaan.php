<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perusahaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'logo',
    ];

    public function layanan()
    {
        return $this->hasMany(Layanan::class);
    }

    public function peran()
    {
        return $this->hasMany(PeranUser::class);
    }

    public function counter()
    {
        return $this->hasMany(Counter::class);
    }
}
