<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Airline extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'logo',
    ];

    public function flights() {
        // 1 pesawat mempunyai banyak penerbangan
        return $this->hasMany(Flight::class);
    }
}