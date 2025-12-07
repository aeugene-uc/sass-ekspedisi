<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuKasus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'pesanan_id',
        'kasus_id',
        'selesai',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function kasus()
    {
        return $this->belongsTo(Kasus::class);
    }
}
