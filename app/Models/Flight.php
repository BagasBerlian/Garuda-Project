<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'flight_number',
        'airline_id'
    ];

    public function airline() {
        // 1 penerbangan hanya dimiliki 1 pesawat
        return $this->belongsTo(Airline::class);
    }

     public function segments() {
        // 1 penerbangan memiliki banyak segment penerbangan
        return $this->hasMany(FlightSegment::class);
    }

    public function classes() {
        // 1 penerbangan memiliki banyak kelas penumpang
        return $this->hasMany(FlightClass::class);
    }

    public function seats() {
        // 1 penerbangan memiliki banyak tempat duduk
        return $this->hasMany(FlightSeat::class);
    }

    public function transactions() {
        // 1 penerbangan memiliki banyak transaksi penumpang
        return $this->hasMany(Transaction::class);
    }
}