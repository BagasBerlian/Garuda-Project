<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlightClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'flight_id',
        'class_type',
        'price',
        'total_seats'
    ];

    public function flight() {
        // 1 kelas penumpang hanya memiliki 1 penerbangan
        return $this->belongsTo(Flight::class);
    }

    public function facilities() {
        // 1 kelas penumpang dapat memiliki banyak fasilitas
        return $this->belongsToMany(Facility::class, 'flight_class_facility', 'flight_class_id', 'facility_id');
    }

    public function transactions() {
        // 1 kelas penumpang dapat memiliki banyak transaksi
        return $this->hasMany(Transaction::class);
    }
}