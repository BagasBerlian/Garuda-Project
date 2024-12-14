<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'flight_id',
        'flight_class_id',
        'name',
        'email',
        'phone',
        'number_of_passengers',
        'promo_code_id',
        'payment_status',
        'subtotal',
        'grandtotal'
    ];

    public function flight() {
        // 1 transaksi hanyak dimiliki 1 penerbangan
        return $this->belongsTo(Flight::class);
    }

    public function class() {
        // 1 transaksi hanyak dimiliki 1 kelas penerbangan
        return $this->belongsTo(FlightClass::class);
    }

    public function promo() {
        // 1 transaksi hanya bisa menggunakan 1 kode promo
        return $this->belongsTo(PromoCode::class);
    }

    public function passengers() {
        // 1 transaksi dapat memiliki banyak transaksi penumpang
        return $this->hasMany(TransactionPassenger::class);
    }
}