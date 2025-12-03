<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Otorisasi extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function peran()
    {
        return $this->belongsToMany(PeranUser::class, 'peranuser_otorisasi', 'otorisasi_id', 'peran_id');
    }
}
