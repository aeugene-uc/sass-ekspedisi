<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['kasus'];

    public function bukuKasus()
    {
        return $this->hasMany(BukuKasus::class);
    }
}
