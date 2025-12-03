<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BukuKasus extends Model
{
    use HasFactory;

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
