<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusPesanan extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'status_id');
    }
}
