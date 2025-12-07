<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPesanan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['status'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
