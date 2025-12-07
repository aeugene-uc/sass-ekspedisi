<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jangkauan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nama'];

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'layanan_jangkauan', 'jangkauan_id', 'layanan_id');
    }
}
