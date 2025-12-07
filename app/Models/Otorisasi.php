<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otorisasi extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nama'];

    public function peranUsers()
    {
        return $this->belongsToMany(PeranUser::class, 'peran_user_otorisasi', 'otorisasi_id', 'peran_id');
    }
}
