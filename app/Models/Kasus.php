<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kasus extends Model
{
    use HasFactory;

    protected $fillable = ['kasus'];

    public function bukuKasus()
    {
        return $this->hasMany(BukuKasus::class);
    }
}
