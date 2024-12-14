<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlightSegment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sequence',
        'flight_id',
        'airport_id',
        'time'
    ];

    public function flight() {
        // 1 segment penerbangan hanya dimiliki oleh 1 penerbangan
        return $this->belongsTo(Flight::class);
    }

    public function airport() {
        // 1 segment penerbangan hanya dimiliki oleh 1 bandara
        return $this->belongsTo(Airport::class);
    }
}