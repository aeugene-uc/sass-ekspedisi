<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jangkauan extends Model
{
    use HasFactory;

    protected $table = 'jangkauan';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'perusahaan_id',
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
