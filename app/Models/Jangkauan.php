<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jangkauan extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'layanan_jangkauan', 'jangkauan_id', 'layanan_id');
    }
}
