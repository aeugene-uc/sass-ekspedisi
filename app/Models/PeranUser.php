<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeranUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['nama'];

    public function users()
    {
        return $this->hasMany(User::class, 'peran_id');
    }
}
