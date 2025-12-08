<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'perusahaan';

    protected $fillable = ['nama', 'logo'];

    public function counters()
    {
        return $this->hasMany(Counter::class);
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class);
    }

    public function peranUsers()
    {
        return $this->hasMany(PeranUser::class);
    }
}
