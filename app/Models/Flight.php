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

    public function airline()
    {
        // 1 penerbangan hanya dimiliki 1 pesawat
        return $this->belongsTo(Airline::class);
    }

    public function segments()
    {
        // 1 penerbangan memiliki banyak segment penerbangan
        return $this->hasMany(FlightSegment::class);
    }

    public function classes()
    {
        // 1 penerbangan memiliki banyak kelas penumpang
        return $this->hasMany(FlightClass::class);
    }

    public function seats()
    {
        // 1 penerbangan memiliki banyak tempat duduk
        return $this->hasMany(FlightSeat::class);
    }

    public function transactions()
    {
        // 1 penerbangan memiliki banyak transaksi penumpang
        return $this->hasMany(Transaction::class);
    }

    // Fungsi untuk generate Seats
    public function generateSeats()
    {
        $classes = $this->classes;

        foreach ($classes as $class) {
            $totalSeats = $class->total_seats;
            $seatsPerRow = $this->getSeatsPerRow($class->class_type);
            $rows = ceil($totalSeats / $seatsPerRow);

            $existingSeats = FlightSeat::where('flight_id', $this->id)
                ->where('class_type', $class->class_type)
                ->get();

            $existingRows = $existingSeats->pluck('row')->toArray();

            $seatCounter = 1;
            for ($row = 1; $row <= $rows; $row++) {
                if (!in_array($row, $existingRows)) {
                    for ($column = 1; $column <= $seatsPerRow; $column++) {
                        if ($seatCounter > $totalSeats) {
                            break;
                        }

                        $seatCode = $this->generateSeatsCode($row, $column);

                        FlightSeat::create([
                            'flight_id' => $this->id,
                            'name' => $seatCode,
                            'row' => $row,
                            'column' => $column,
                            'is_available' => true,
                            'class_type' => $class->class_type,
                        ]);
                        $seatCounter++;
                    }
                }
            }

            foreach ($existingSeats as $existingSeat) {
                if ($existingSeat->column > $seatsPerRow || $existingSeats->row > $row) {
                    $existingSeat->is_available = false;
                    $existingSeat->save();
                }
            }
        }
    }

    protected function getSeatsPerRow($classType)
    {
        switch ($classType) {
            case 'economy':
                return 4;
            case 'bussiness':
                return 6;
            default:
                return 4;
        }
    }

    private function generateSeatsCode($row, $column)
    {
        $rowLetter = chr(64 + $row);
        return $rowLetter . $column;
    }
}